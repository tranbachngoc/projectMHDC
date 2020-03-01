<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Notification;
use App\Models\Device;
use Illuminate\Support\Facades\Log;
use Edujugon\PushNotification\PushNotification;
use App\Models\ChatThreadUser;
use DB;

class SendChatNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    const SERVICE_FCM = 'fcm';
    const SERVICE_APN = 'apn';

    protected $data;
    protected $type;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        switch ($this->type) {
            case 'join-group':
                $this->pushNotificationJoinGroupToUser();
                break;

            case 'init-call':
                $this->pushNotificationInitCall();
                break;

            case 'usercancel-call':
                $this->pushNotificationCancelCall();
                break;

            case 'send-new-message':
                $this->pushNotificationSendMessage();
                break;

            case 'repeat-conversation':
                $this->pushNotificationRepeatConversation();
                break;

            case 'create-follow':
                $this->createFollow();
                break;


            default:
                # code...
                break;
        }
    }

    private function pushNotificationJoinGroupToUser() {
        //$id = DB::table('chatthreads')->insertGetId(['namegroup' => 'This is data job']);
        $data = $this->data; // user model
        $userIds = $data['userIds'];
        $dataSend = ['actionType' => 'chatmessage',
                    'title' => 'Thông báo mời tham gia nhóm chat',
                    'body' => $data['ownerName'] ." mời bạn tham gia nhóm " . $data['groupName'],
                ];
        $this->sendFCM($userIds, $dataSend);
    }

    public function pushNotificationInitCall() {
        $data = $this->data;
        $userIds = $data['userIds'];
        unset($data['userIds']);
        $dataSend = ['actionType' => 'init-call',
                    'title' => 'Bạn có cuộc gọi ',
                    'body' => 'Bạn có cuộc gọi',
                    'data' => $data

                ];

        $this->sendAPN($userIds, $dataSend);
    }

    public function pushNotificationCancelCall() {
        $data = $this->data;
        $userIds = $data['userIds'];
        unset($data['userIds']);
        $dataSend = ['actionType' => 'usercancel-call',
                    'title' => 'Cancel cuoc goi ',
                    'body' => 'Cancel cuoc goi',
                    'data' => $data

                ];

        $this->sendAPN($userIds, $dataSend);
    }


    public function pushNotificationSendMessage() {
        $data = $this->data;
        $userIds = $data['userIds'];
        unset($data['userIds']);
        $dataSend = ['actionType' => 'send-new-message',
                    'title' => 'Send new message ',
                    'body' => 'Send new message',
                    'data' => $data
                ];

        $this->sendAPNMessage($userIds, $dataSend, $data['ownerId']);
    }

    private function sendAPN($userIds, $data) {
        $list = Device::where('type', Device::TYPE_IOS)
            ->where('userId',"<>", $data['data']['use_id'])
            ->whereIn('userId', $userIds)
            ->whereNotNull('token_voip')
            ->where("token_voip", "<>", "")
            ->distinct("token_voip")
            ->pluck('token_voip');
        if (sizeof($list) === 0) {
            return;
        }
        $tokens = $list->toArray();
        /*$message = [
            'aps' => [
                'alert' => [
                    'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                    'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                ],
                'sound' => 'default'
            ],
            'extraPayLoad' => $data
        ];*/

        $message = [
            "aps" => [
                "content-available" => 1,
                "sound" => "",
                "priority" => 5
            ],
            'extraPayLoad' => $data
        ];

        $pushNotification = new PushNotification(self::SERVICE_APN);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        //Log::error('Send call Ios '.json_encode($pushNotification->getFeedback()));
    }

    private function sendAPNMessage($userIds, $data, $ownerId) {
        //Log::info("user info message khi send" . json_encode($userIds));
        if(count($userIds) <= 0){
            return;
        }
        $list = Device::where('type', Device::TYPE_IOS)
                        ->where('userId',"<>", $ownerId)
                        ->whereIn('userId', $userIds)
                        ->whereNotNull('token_voip')
                        ->distinct("token_voip")
                        ->pluck('token_voip');
        if(count($list) <= 0) {
            return;
        }
        if (sizeof($list) === 0) {
            return;
        }
        $tokens = $list->toArray();
        /*$message = [
            'aps' => [
                'alert' => [
                    'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                    'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                ],
                'sound' => 'default'
            ],
            'extraPayLoad' => $data
        ];*/
        $message = [
            "aps" => [
                "content-available" => 1,
                "sound" => "",
                "priority" => 5
            ],
            'extraPayLoad' => $data
        ];

        $pushNotification = new PushNotification(self::SERVICE_APN);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        //Log::error('Send message Ios '.json_encode($pushNotification->getFeedback()));
    }



    private function sendFCM($userIds, $data) {
        $list = Device::where('type', Device::TYPE_IOS)->whereIn('userId', $userIds)->pluck('token');
        if (sizeof($list) === 0) {
            return;
        }
        $tokens = $list->toArray();
        $message = [
            'collapse_key' => $data['actionType'],
            //"content_available" => true,
            "priority" =>  "high",
            /*"notification" => [
                "sound" =>  ""
            ],*/
            'notification' => [
                'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                'sound' => 'default'
            ],
            'data' => $data['data']

        ];
        $pushNotification = new PushNotification(self::SERVICE_FCM);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        //Log::error('Send call IOS '.json_encode($pushNotification->getFeedback()));
    }

    private function sendFCMAndroid($userIds, $data) {
        $list = Device::where('type', Device::TYPE_ANDROID)->whereIn('userId', $userIds)->pluck('token');
        if (sizeof($list) === 0) {
            return;
        }
        $data['data']['actionType'] =  $data['actionType'];
        $data['data']['timestamp'] = date('Y-m-d H:i:s');
        $data['data']['actionId'] = $data['id'];
        $data['data']['title'] =  isset($data['title']) ? $data['title']. date('Y-m-d H:i:s') : 'Bạn có thông báo mới' .date('Y-m-d H:i:s');
        $data['data']['body'] =  isset($data['body']) ? $data['body']. date('Y-m-d H:i:s') : 'Bạn có thông báo mới' .date('Y-m-d H:i:s');
        $tokens = $list->toArray();
        if($data['actionType'] == 'repeat-conversation') {
            $message = [
                'collapse_key' => $data['actionType'],
                //"content_available" => true,
                "priority" =>  "high",
                /*"notification" => [
                    "sound" =>  ""
                ],*/
                'notification' => [
                    'title' => isset($data['title']) ? $data['title']. date('Y-m-d H:i:s') : 'Bạn có thông báo mới' .date('Y-m-d H:i:s'),
                    'body' =>  isset($data['body']) ? $data['body']. date('Y-m-d H:i:s') : 'Bạn có thông báo mới' .date('Y-m-d H:i:s') ,
                    'sound' => 'default'
                ],
                'data' => $data['data']

            ];
        }
        else {
            $message = [
                'collapse_key' => $data['actionType'],
                //"content_available" => true,
                "priority" =>  "high",
                /*"notification" => [
                    "sound" =>  ""
                ],*/
                'notification' => [
                    'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                    'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                    'sound' => 'default'
                ],
                'data' => $data['data']

            ];
        }

        $pushNotification = new PushNotification(self::SERVICE_FCM);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        //Log::error('Send Android '.json_encode($pushNotification->getFeedback()));
    }


    public function pushNotificationRepeatConversation() {
        $data = $this->data;
        $userIds = $data['userIds'];
        unset($data['userIds']);
        $dataSend = ['actionType' => 'repeat-conversation',
                    'title' => 'Send repeat conversation ',
                    'body' => 'Send repeat conversation',
                    'data' => $data['detail']
                ];
        //Log::info("user repeat conversation " . json_encode($userIds));
        $this->sendAPN($userIds, $dataSend);
        $this->sendFCMAndroid($userIds, $dataSend);


    }

    public function createFollow() {
        $data = $this->data;
        $userId = $data['userId'];
        $arrUserFollow = $data['arrUserFollow'];
        ChatThreadUser::createFollow($userId, $arrUserFollow);
        //Log::info("user create follow " . json_encode($arrUserFollow));

    }
}
