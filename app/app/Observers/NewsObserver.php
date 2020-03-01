<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Models\Notification;
use App\Jobs\SendNewsNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class NewsObserver extends AbstractObserver {

    public function saved($model) {
        if (!$model->isDirty()) {
            return;
        }

        if ($model->wasNew) {
           
            $user = $model->user;
            if ($user->use_group == User::TYPE_AffiliateStoreUser) {
           
                
                dispatch(new SendNewsNotification(Notification::TYPE_CTY_CREATE_NEWS, $model));
                
            }
        }
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }

    public function pushNotification($model) {
       
    }

}
