<?php
namespace App\Components;
use App\Models\Device;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Log;
class Notification {

    static function sendFCM($userIds, $data) {
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

        $pushNotification = new PushNotification('fcm');
        $pushNotification->setMessage($message);
        $pushNotification->setDevicesToken($tokens);
        $pushNotification->send();
        Log::error('Send Android ' . json_encode($pushNotification->getFeedback()));
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

