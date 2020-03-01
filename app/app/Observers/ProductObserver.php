<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Models\User;
use App\Models\Shop;

use App\Mail\RegisterAffiliate;
use App\Mail\RegisterShop;
use App\Mail\RegisterMember;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Jobs\SendProductNotification;
use App\Models\Product;
class ProductObserver extends AbstractObserver {

    public function saved($model) {
        if ($model->isDirty() && $model->getOriginal('pro_status') == Product::STATUS_ACTIVE && $model->pro_status != Product::STATUS_ACTIVE) {
          
            dispatch(new SendProductNotification(Notification::TYPE_DEACTIVE_PRODUCT, $model));
            dispatch(new SendProductNotification(Notification::TYPE_CTY_DEACTIVE_PRODUCT, $model));
        }
        if ($model->wasNew) {
            
            dispatch(new SendProductNotification(Notification::TYPE_CTY_CREATE_NEW_PRODUCT, $model));
        }
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }


  


}
