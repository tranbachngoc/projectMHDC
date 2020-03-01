<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Notification;
use App\Models\Device;
use Illuminate\Support\Facades\Log;
use Edujugon\PushNotification\PushNotification;

class SendProductNotification implements ShouldQueue
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
    public function handle() {
        Log::info("Jobs Send Notification ");
        switch ($this->type) {

            case Notification::TYPE_DEACTIVE_PRODUCT:
                $this->pushDeactiveProduct();
                break;
            case Notification::TYPE_BRANCH_CREATE_PRODUCT:
                break;
            case Notification::TYPE_CTY_DEACTIVE_PRODUCT:
                $this->pushDeactiveProductToBranch();
                 break;
            case Notification::TYPE_CTY_CREATE_NEW_PRODUCT:

                $this->pushCreateProductNotification();
                break;
            default:
                # code...
                break;
        }
    }
    //Branch - Công ty của bạn vừa tải lên sản phẩm mới
    private function pushCreateProductNotification() {
        $product = $this->data;  // comment model

        $branchs = $this->getAllEmployee( $product->pro_user)->pluck('use_id')->toArray();

        $this->saveNotification($branchs, [
            'actionId' => $product->pro_user,
            'title' => 'Công ty của bạn vừa tải lên sản phẩm mới',
            'body' => 'Công ty của bạn vừa tải lên sản phẩm mới',
            'actionType' => $this->type,
            'meta' => [
                'pro_id' => $product->pro_id,
                'pro_user' => $product->pro_user
            ]
        ]);
    }

    // notif
    private function pushDeactiveProduct() {
        $product = $this->data;  // comment model
        

        $this->saveNotification($product->pro_user, [
            'actionId' => $product->pro_id,
            'title' => 'Sản phẩm có mã ' . $product->pro_id . ' đã bị ngừng kích hoạt.',
            'body' => 'Sản phẩm có mã ' . $product->pro_id . ' đã bị ngừng kích hoạt.',
            'actionType' => $this->type,
            'meta' => [
                'pro_id' => $product->pro_id,
                'pro_user' => $product->pro_user
            ]
        ]);
    }
    
    private function pushDeactiveProductToBranch() {
        $product = $this->data;  // comment model
        $branchs = User::where(['use_group' => User::TYPE_BranchUser, 'parent_id' => $product->pro_user])->pluck('use_id')->toArray();

        $this->saveNotification($branchs, [
            'actionId' => $product->pro_id,
            'title' => 'Sản phẩm có mã ' . $product->pro_id . ' từ Công ty của bạn đã ngừng kích hoạt.',
            'body' => 'Sản phẩm có mã ' . $product->pro_id . ' từ Công ty của bạn đã ngừng kích hoạt.',
            'actionType' => $this->type,
            'meta' => [
                'pro_id' => $product->pro_id,
                'pro_user' => $product->pro_user
            ]
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
    
    protected function getAllEmployee($user){
        $tree = [];
        $tree[] = $user->use_id;
        $query = User::where(['use_status' => User::STATUS_ACTIVE])->whereIn('use_group',[User::TYPE_AffiliateUser,User::TYPE_BranchUser]);
        $query->whereIn('parent_id', function($q) use ($user) {
            $q->select('use_id');
            $q->from((new User)->getTable());
            $q->where('use_status', User::STATUS_ACTIVE);
            $q->where(function($q2) use ($user) {
                $q2->whereIn('use_group', [User::TYPE_StaffStoreUser, User::TYPE_StaffUser, User::TYPE_BranchUser,
                    User::TYPE_AffiliateStoreUser,User::TYPE_Partner2User,User::TYPE_Partner1User,User::TYPE_Developer1User,User::TYPE_Developer2User]);
                $q2->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $user->use_id]);
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($user) {
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where(function($q) use ($user) {
                        $q->where('use_group', User::TYPE_BranchUser);
                        $q->where(['use_status' => User::STATUS_ACTIVE, 'parent_id' => $user->use_id]);
                    });
                });
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_StaffUser);
                $q->whereIn('parent_id', function($q) use($user){
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where('use_status', User::STATUS_ACTIVE);
                    $q->where('use_group', User::TYPE_BranchUser);
                    $q->whereIn('parent_id', function($q) use($user) {
                        $q->select('use_id');
                        $q->from(User::tableName());
                        $q->where('use_group', User::TYPE_StaffStoreUser);
                        $q->where('parent_id',$user->use_id);
                    });
                });
            });
            $q->orWhere(function($q) use($user) {
                $q->where('use_group', User::TYPE_BranchUser);
                $q->where('use_status', User::STATUS_ACTIVE);
                $q->whereIn('parent_id', function($q) use($user) {
                    $q->select('use_id');
                    $q->from(User::tableName());
                    $q->where('use_group', User::TYPE_StaffStoreUser);
                     $q->where('parent_id',$user->use_id);
                });
            });
            $q->orWhere('use_id', $user->use_id);
        });
        
        
        return $query->pluck('use_id')->toArray();
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
