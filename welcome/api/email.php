<?php
    require_once('config.php'); // Path to config file

    if (isset($_POST['email'])) {
        // MESSAGE SUBJECT
        $subject = 'New Message from '.$_POST['name'];

        $name = $_POST['name'];
        $from = $_POST['email'];
        $message = $_POST['message'];

        $headers .= "Reply-To: ". $from ."\r\n";
        $headers .= "Return-Path: ". $from ."\r\n";
        $headers .= "X-Mailer: PHP\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

        // Additional headers
        $headers .= 'From: '. $name .' <"'. $from .'">' . "\r\n";

        mail(EMAIL, $subject, $message, $headers);

        exit;
    }