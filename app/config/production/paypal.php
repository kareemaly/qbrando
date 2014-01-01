<?php

return array(

    'payment' => array(
        'currency' => 'USD',
        'action' => 'Sale'
    ),

    'settings' => array(

        "mode" => "live",

        "acct1.UserName" => "leaguemen_api1.hotmail.com",
        "acct1.Password" => "J5V6ZBQHB2VD9H8R",
        "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31AkBIQAKIUxRemQflykHMHS9KPFvl",

        // Certificate path relative to config folder or absolute path in file system
        // "acct1.CertPath" => "cert_key.pem",
        // "acct1.AppId" => "APP-80W284485P519543T"
    ),

    'url' => 'https://www.paypal.com/webscr'
);