<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paypal' => [
        'client_id' => 'AegJY451w10WvNb-nnwR56OCLVyS6g4lJ_E41aJECKdmmOSwhcUhYy8deBPrwqEFkEkQP5v3O4SucS-N',
        'secret' => 'EIJOVXWCjbXoXHYtjXoWb5mffUEUb0xNYl9ezctZ-bCDMagHwZuTfTX_PZO1NL1k_n1oLDn8QEt94YMf',
    ]
];
