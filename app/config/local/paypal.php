<?php

return array(

    'payment' => array(
        'currency' => 'USD',
        'action' => 'Sale'
    ),

    'settings' => array(

        "mode" => "sandbox",

        "acct1.UserName" => "leaguemen-facilitator_api1.hotmail.com",
        "acct1.Password" => "1386438493",
        "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31AWlc6q8EedzoXJhqKGSiaIilgMGm",

        // Certificate path relative to config folder or absolute path in file system
        // "acct1.CertPath" => "cert_key.pem",
        // "acct1.AppId" => "APP-80W284485P519543T"
    ),

    'url' => 'https://www.sandbox.paypal.com/webscr'
);