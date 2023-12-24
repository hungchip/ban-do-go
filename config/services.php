<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '742875069588229',  //client face của bạn
        'client_secret' => 'fc66281188f6172a0b53a029fbb0a635',  //client app service face của bạn
        'redirect' => 'https://dogoducluong.com/datn/callback/facebook' //callback trả về
    ],
    'google' => [
        'client_id' => '999567238042-cud7clfjk88h2bplisv87cu8k627adu5.apps.googleusercontent.com',
        'client_secret' => '_Q4ZrjLcoYrxm-7FiFB8wa9m',
        'redirect' => 'https://dogoducluong.com/datn/callback/google'
    ],


];
