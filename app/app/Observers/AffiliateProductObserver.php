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
use App\Jobs\SendAffProductNotification;

class AffiliateProductObserver extends AbstractObserver {

    public function saved($model) {
     
        if ($model->wasNew) {
           $data = $model->toArray();
            dispatch(new SendAffProductNotification(Notification::TYPE_AFFILIATE_SELECT_BUY_PRODUCT, $data));
        }
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
	
    }

}
