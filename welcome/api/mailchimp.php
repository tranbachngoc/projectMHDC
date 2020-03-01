<?php
    require_once('config.php'); // Path to config file

    // Check if keys are in place
    if (MC_API_KEY === '' || MC_LIST_ID === '') {
        echo 'You need a consumer key and secret keys. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
      
        exit;
    }

    $double_optin   = false;
    $send_welcome   = false;
    $email_type     = 'html';
    $email          = $_POST['email'];

    //replace us4 with your actual datacenter
    $submit_url     = "http://us4.api.mailchimp.com/1.3/?method=listSubscribe";

    $data = array(
        'email_address' => $email,
        'apikey'        => MC_API_KEY,
        'id'            => MC_LIST_ID,
        'double_optin'  => $double_optin,
        'send_welcome'  => $send_welcome,
        'email_type'    => $email_type,
    );

    $payload = json_encode($data);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $submit_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
     
    $result = curl_exec($ch);
    curl_close ($ch);

    $data = json_decode($result);

    header('Content-Type: application/json');
    if ($data->error){
        echo json_encode(array( 'error' => true, 'message' => $data->error ));
    } else {
        echo json_encode(array( 'error' => false, 'message' => "Got it, you've been added to our email list." ));
    }