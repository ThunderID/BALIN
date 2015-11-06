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

    'mandrill' => [
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
        'client_id'     => '564811090365486',
        'client_secret' => 'c0f6e589dac1d671d76e7086fcd87ce4',
        'redirect'      => 'http://localhost:8000/',
    ],
];
