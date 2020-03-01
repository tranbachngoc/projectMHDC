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
use App\Models\User;
use App\Models\Product;
use App\Components\Notification as HelperNotification;

class SendAffProductNotification implements ShouldQueue {

    use InteractsWithQueue,
        Queueable,
        SerializesModels;

    const SERVICE_FCM = 'fcm';
    const SERVICE_APN = 'apn';

    protected $data;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $data) {
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

            case Notification::TYPE_AFFILIATE_SELECT_BUY_PRODUCT:
                $this->pushSelectProduct();
                break;
             case Notification::TYPE_AFFILIATE_REMOVE_SELECT_BUY_PRODUCT:
                $this->pushRemoveSelectProduct();
                break;
            default:
                # code...
                break;
        }
    }
    
    private function pushRemoveSelectProduct() {
        $affProduct = $this->data;  // comment model
        $user = User::where('use_id',$affProduct['use_id'])->first();
       
        $product = Product::where('pro_id',$affProduct['pro_id'])->first();
        if (empty($user) || empty($product)) {
            return;
        }
        
        $this->saveNotification($product->pro_user, [
            'actionId' => $user->use_id,
            'title' => $user->use_fullname . ' đã hủy chọn bán sản phẩm có mã ' . $product->pro_id . ' của bạn',
            'body' => $user->use_fullname . ' đã hủy chọn bán sản phẩm có mã ' . $product->pro_id . '  của bạn',
            'actionType' => $this->type,
            'meta' => [
                'use_id' => $product->pro_user,
                'pro_id' => $product->pro_id
            ]
        ]);
    }

    // notif
    private function pushSelectProduct() {
        $affProduct = $this->data;  // comment model
       $user = User::where('use_id',$affProduct['use_id'])->first();
       
        $product = Product::where('pro_id',$affProduct['pro_id'])->first();
        if (empty($user) || empty($product)) {
            return;
        }

        $this->saveNotification($product->pro_user, [
            'actionId' => $user->use_id,
            'title' => $user->use_fullname . ' đã chọn bán sản phẩm có mã '.$product->pro_id.' của bạn',
            'body' => $user->use_fullname . ' đã chọn bán sản phẩm có mã '.$product->pro_id.'  của bạn',
            'actionType' => $this->type,
            'meta' => [
                'pro_id' => $product->pro_id,
                'use_id' => $product->pro_user
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

        HelperNotification::sendFCM($userIds, $data);
    }

}
