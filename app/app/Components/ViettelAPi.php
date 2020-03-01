<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Components;

/**
 * Description of ViettelAPi
 *
 * @author hoanvu
 */
class ViettelAPi {

    public $URL_REQUEST = "https://api.viettelpost.com.vn:8446/api/VTPTMDT/";
    protected  $userName;
    protected $password;
    protected $appKey;
        function __construct() {
        $this->userName = env('VT_USERNAME', 'AZB');
        $this->password = env('VT_PASSWORD', 'xmHNU#2_S[32v{:N');
        $this->appKey = env('VT_APPKEY', 'LmfNRXQfd8+66POBa+z10Q==');
        //parent::__construct();
    }

    public function Login()
    {
        $curl = curl_init();
        $arrayUser = array(
            'UserName' => $this->userName,
            'Password' => $this->password,
            'AppKey' =>$this->appKey
        );

        $data = json_encode($arrayUser);
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8446",
            CURLOPT_URL => $this->URL_REQUEST."Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
            CURLOPT_PROXY, true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response["TokenKey"];
        }
    }

    public function LoginV2() {

        $ch = curl_init($this->URL_REQUEST."Login");
        # Setup request to send json via POST.
        $arrayUser = array(
            'UserName' => 'AZB',
            'Password' => 'xmHNU#2_S[32v{:N',
            'AppKey' => 'LmfNRXQfd8+66POBa+z10Q=='
        );

        $payload = json_encode($arrayUser);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
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
            $response = json_decode($result, true);
            return $response["TokenKey"];
        } catch (Exception $ex) {
            return false;
        }
    }


    public function callMethod($method, $data, $token,$request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8446",
            CURLOPT_URL => $this->URL_REQUEST.$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Token: ".$token
            ),
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

}
