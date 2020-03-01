<?php
namespace App\Components;

class G {

    /**
     * get avatar from google
     *
     * @param string $gId
     * @return string
     */
    public static function getAvatarUrl($gId) {
       $url = 'https://content.googleapis.com/plus/v1/people/' . $gId . '?fields=image&key=' . env('GOOGLE_MAP_KEY');
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       $response = curl_exec($ch);
       curl_close($ch);
       $response_a = json_decode($response, true);

       return !empty($response_a['image']) ? $response_a['image']['url'] : null;
   }
}