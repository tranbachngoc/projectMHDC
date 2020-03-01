<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Models\Notification;
use App\Jobs\SendNotification;

class CommentObserver extends AbstractObserver {

    public function saved($model) {
        if (!$model->isDirty()) {
            return;
        }

        if ($model->wasNew) {
            dispatch(new SendNotification(Notification::TYPE_NEW_COMMENTS, $model));
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
