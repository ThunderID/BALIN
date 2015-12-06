<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key' => '',
        'secret' => '',
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID', '491225264379551'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '548dc7aa90470c9be30648377d9ce3ba'),
        'redirect'      => env('FACEBOOK_REDIRECT', 'http://localhost:8000/sso/success'),
    ],

    'mandrill' => [
        'secret' => env('MAIL_PASSWORD', ''),
    ],
];
