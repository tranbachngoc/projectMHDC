<?php

namespace App\Observers;

use App\Observers\AbstractObserver;
use App\Models\User;


use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Jobs\SendNotification;
use Lang;
use App\Helpers\Hash;
class ForgotPasswordObserver extends AbstractObserver {

    public function saved($model) {
        
        if (!$model->isDirty()) {
        	return;
        }

        if ($model->wasNew) {

        	$this->sendMailAndNotiy($model);
        }
        
    }

    public function saving($model) {
        
    }

    public function deleting($model) {
        
    }

    public function deleted($model) {
        
    }


    private function sendMailAndNotiy($model) {
        $user = User::where(['use_email'=> $model->for_email])->first();
       
        if (empty($user)) {
            return;
        }
         $user_name = $user->use_username;
        $mailData = [
            'user_name' => $user_name,
            'settingAddress_1' => '92 Trần Quốc Toản, Phường 8, Quận 3, Tp.HCM',
            'settingPhone' => '0873009910',
            'settingEmail_1' => 'info@azibai.com',
            'keySend' => env('APP_FONTEND_URL') . '/forgot/reset/key/' . $model->for_key . '/token/' . Hash::create($model->for_email, $model->for_key, "sha512md5")
        ];
        
        Mail::to($model->for_email)->send(new ForgotPassword($mailData));
    }

}
