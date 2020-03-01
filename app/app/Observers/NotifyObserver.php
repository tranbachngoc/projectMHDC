<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Jobs\SendNotification;

class NotifyObserver extends AbstractObserver {

    public function saved($model) {
        if (!$model->isDirty()) {
            return;
        }

        if ($model->wasNew) {
            
        }
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }

}
