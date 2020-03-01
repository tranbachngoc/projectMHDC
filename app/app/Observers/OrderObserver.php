<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Jobs\SendNotification;
use App\Models\Order;
use App\Models\Notification;
use App\Mail\ShopAcceptOrder;
use App\Models\OrderDetail;
use App\Models\GiaoHangNhanhLog;
class OrderObserver extends AbstractObserver {

    public function saved($model) {
        if (!$model->isDirty()) {
            return;
        }

        if ($model->wasNew) {
            dispatch(new SendNotification(Notification::TYPE_NEW_ORDER, $model));
        }

        if ($model->isDirty('order_status') && $model->getOriginal('order_status') !== $model->order_status) {
//            if($model->order_status == Order::STATUS_ON_TRANS){
//                $this->sendMailAcceptOrder($model);
//            } 
            if ($model->order_status == Order::STATUS_CANCEL) {
                $this->cancelOrder($model);
            }

            if (in_array($model->order_status, [Order::STATUS_CANCEL, Order::STATUS_ON_TRANS, Order::STATUS_SUCCESS])) {
                dispatch(new SendNotification(Notification::TYPE_STATUS_ORDER, $model));
            }
        }
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }

    protected function cancelOrder($model) {
        OrderDetail::where('shc_orderid', $model->id)
        ->update([
            'shc_status' => $model->order_status,
            'shc_change_status_date' => time()
        ]);
        GiaoHangNhanhLog::create([
            'OrderCode' => $model->order_clientCode,
            'TotalFee' => $model->shipping_fee,
            'owner' => $model->order_saler,
            'logaction' => 'Hủy đơn hàng thành công',
            'lastupdated' => date('Y-m-d H:i:s', time())
        ]);
        //TODO Send mail sendingCancelOrderEmailForCustomer
        
        
    }
    protected function sendMailAcceptOrder($model) {
        Mail::to($model->use_email)->send(new ShopAcceptOrder($model));
    }

}
