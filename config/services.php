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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Cobro con QR de Banco FIE (sip.mc4.com.bo). Las credenciales
    // (usuario / password / idServicio / callback) van por empresa, en la
    // tabla `empresa`. Aqui solo la URL base y el toggle de verificacion SSL.
    'bancofie' => [
        'base_url' => env('BANCOFIE_BASE_URL', 'https://sip.mc4.com.bo:8443'),
        'verify_ssl' => env('BANCOFIE_VERIFY_SSL', true),
        'timeout' => env('BANCOFIE_TIMEOUT', 20),
    ],

];
