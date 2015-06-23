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

    'mailgun'  => [
        'domain' => '',
        'secret' => '',
    ],
    'mandrill' => [
        'secret' => 'NamYd7YGxAMJ-PcpxLp-vQ',
    ],
    'places'   => [
        'secret' => 'AIzaSyB2rg8AsguVnUDfFOKE_4SjIyoRGEZNDis',
    ],
    'ses'      => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],
    'stripe'   => [
        'model'  => 'App\User',
        'secret' => env('STRIPE_KEY'),
    ],

    'xero' => [
        'application_type'    => "Private",
        'oauth_callback'      => "oob",
        'user_agent'          => "XeroOAuth-PHP Private Koolbeans",
        'consumer_key'        => 'PMZWIRNCL7MFLOIX15XTN6PAYI1CPF',
        'access_token'        => 'PMZWIRNCL7MFLOIX15XTN6PAYI1CPF',
        'shared_secret'       => 'UQPIGXYC5MYM3B7QKOPL77L99ALNLH',
        'access_token_secret' => 'UQPIGXYC5MYM3B7QKOPL77L99ALNLH',
        'core_version'        => '2.0',
        'payroll_version'     => '1.0',
        'file_version'        => '1.0',
        'rsa_private_key'     => '/etc/ssl/certs/koolbeans.pem',
        'rsa_public_key'      => '/etc/ssl/certs/koolbeans.cer',
    ]

];
