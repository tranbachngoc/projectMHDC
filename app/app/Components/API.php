<?php
namespace App\Components;
use App\Models\Setting;

class API {

    /**
     * call the hook to add revenue to driver
     *
     * @return Array
     */
    public static function addRevenue($driverId, $wallet, $data = []) {
         //call the portal hook for new price
        $urlAddRevenue = Setting::where('key', Setting::KEY_ADD_REVENUE)->first();
        $accessKey = Setting::where('key', Setting::KEY_ACCESS_KEY)->first();

        if (!$accessKey || !$urlAddRevenue) {
            return false;
        }

        $ch = curl_init($urlAddRevenue->meta['value']);
        # Setup request to send json via POST.
        $payload = json_encode([
            'wallet' => $wallet,
            'driverId' => $driverId,
            'data' => $data
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Access-key: '.$accessKey->meta['value']));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        try {
            $newData = json_decode($result, true);
            //verify, the response must include new price, some description and info about that
            return $newData;
        } catch (Exception $ex) {
            return false;
        }
    }


    /**
     * call the hook to push notification
     *
     * @return Array
     */
    public static function pushNotification($data = []) {
         //call the portal hook for new price
        $urlPushNotification = Setting::where('key', Setting::KEY_PUSH_NOTIFICATION)->first();
        $accessKey = Setting::where('key', Setting::KEY_ACCESS_KEY)->first();

        if (!$accessKey || !$urlPushNotification) {
            return false;
        }

        $ch = curl_init($urlPushNotification->meta['value']);
        # Setup request to send json via POST.
        $payload = json_encode([
            'title' => $data['title'],
            'shortContent' => $data['shortContent'],
            'content' => $data['content'],
            'userType' => $data['userType'],
            'ids' => $data['ids']
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Access-key: '.$accessKey->meta['value']));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        try {
            $newData = json_decode($result, true);
            //verify, the response must include new price, some description and info about that
            return $newData;
        } catch (Exception $ex) {
            return false;
        }
    }


}