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

class SendNotification implements ShouldQueue
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
        Log::info("Jobs Send Notification ");
        switch ($this->type) {
            case Notification::TYPE_NEW_COMMENTS:
                $this->pushNewComments();
                break;
            case Notification::TYPE_NEW_BRANCH_USER: // chi nhánh mới
                $this->pushNewBranchUser();
                break;
            case Notification::TYPE_NEW_AFFILIATE_USER: // chi nhánh mới
                $this->pushNewAffiliateUser();
                break;
            case Notification::TYPE_NEW_ORDER: // order mới
                $this->pushNewOrder();
                break;
            case Notification::TYPE_STATUS_ORDER: // order thay đổi trạng thái
                $this->pushStatusOrder();
                break;
            default:
                # code...
                break;
        }
    }

    // notif
    private function pushNewComments() {
        $comment = $this->data;  // comment model
        $userIds = $comment->getRelatedUserIds();

        $this->saveNotification($userIds, [
            'actionId' => $comment->noc_id,
            'title' => 'Có người bình luận về tin tức của bạn',
            'body' => $comment->noc_name. ' đã bình luận về tin tức của bạn',
            'actionType' => $this->type,
            'meta' => [
                'noc_content' => $comment->noc_content,
                'id' => $comment->noc_id
            ]
        ]);
    }

    private function pushNewBranchUser() {
        $user = $this->data; // user model

        $this->saveNotification($user->parent_id, [
            'actionId' => $user->use_id,
            'title' => 'Bạn vừa có thêm chi nhánh mới',
            'body' => 'Bạn vừa có thêm chi nhánh mới',
            'actionType' => $this->type
        ]);
    }

    private function pushNewAffiliateUser() {
        $user = $this->data; // user model

        $this->saveNotification($user->parent_id, [
            'actionId' => $user->use_id,
            'title' => 'Bạn vừa có thêm Đại lý bán lẻ online mới',
            'body' => 'Bạn vừa có thêm Đại lý bán lẻ online mới',
            'actionType' => $this->type
        ]);
    }

    private function pushNewOrder() {
        $order = $this->data; // order model

        $this->saveNotification($order->order_saler, [
            'actionId' => $order->id,
            'title' => 'Thông báo có đơn đặt hàng mới',
            'body' => 'Bạn vừa có đơn đặt hàng mới #'.$order->id,
            'actionType' => $this->type
        ]);
    }

    private function pushStatusOrder() {
        $order = $this->data; // order model

        $this->saveNotification($order->order_user, [
            'actionId' => $order->id,
            'title' => 'Thông báo trạng thái đơn hàng đã thay đổi.',
            'body' => $order->getMessageByStatus(),
            'actionType' => $this->type
        ]);
    }

    private function saveNotification($userIds, $data) {
        if (!$userIds) {
            return;
        }
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        $list = [];
        foreach ($userIds as $value) {
            $list[] = array(
                'actionType' => $this->type,
                'actionId' => isset($data['actionId']) ? $data['actionId'] : null,
                'title' => isset($data['title']) ? $data['title'] : null,
                'body' => isset($data['body']) ? $data['body'] : null,
                'meta' => isset($data['meta']) ? json_encode($data['meta']) : null,
                'userId' => $value,
                'createdAt' => time(),
                'updatedAt' => time()
            );
        }
        Notification::insert($list);

        $this->sendFCM($userIds, $data);
    }

    private function sendAPN($userIds, $data) {
        $list = Device::where('type', Device::TYPE_IOS)->whereIn('userId', $userIds)->pluck('token');
        if (sizeof($list) === 0) {
            return;
        }
        
        $tokens = $list->toArray();

        $message = [
            'aps' => [
                'alert' => [
                    'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                    'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                ],
                'sound' => 'default'
            ],
            'extraPayLoad' => $data
        ];

        $pushNotification = new PushNotification(self::SERVICE_APN);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        Log::error('Send Ios '.json_encode($pushNotification->getFeedback()));
    }

    private function sendFCM($userIds, $data) {
        $list = Device::whereIn('userId', $userIds)->pluck('token');
        if (sizeof($list) === 0) {
            return;
        }
        $tokens = $list->toArray();

        $message = [
            'collapse_key' => $data['actionType'],
            'notification' => [
                'title' => isset($data['title']) ? $data['title'] : 'Bạn có thông báo mới',
                'body' => isset($data['body']) ? $data['body'] : 'Bạn có thông báo mới',
                'sound' => 'default'
            ],
            'data' => $data
        ];

        $pushNotification = new PushNotification(self::SERVICE_FCM);
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        Log::error('Send Android '.json_encode($pushNotification->getFeedback()));
    }
}
