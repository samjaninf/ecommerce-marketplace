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
        'secret' => 'sk_test_fNCMV9dZEwNvPs3wf2OBBohK',
    ],
    'xero'     => [
        'application_type'    => "Private",
        'oauth_callback'      => "oob",
        'user_agent'          => "XeroOAuth-PHP Private Koolbeans",
        'consumer_key'        => 'WYR4X31O89SZBA2K4ESKWR2IPWRRJT',
        'access_token'        => 'WYR4X31O89SZBA2K4ESKWR2IPWRRJT',
        'shared_secret'       => 'BXIILY9Z4WTXFCAUBGML8788WO2WKN',
        'access_token_secret' => 'BXIILY9Z4WTXFCAUBGML8788WO2WKN',
        'core_version'        => '2.0',
        'payroll_version'     => '1.0',
        'file_version'        => '1.0',
        'rsa_private_key'     => '/etc/ssl/certs/koolbeans.pem',
        'rsa_public_key'      => '/etc/ssl/certs/koolbeans.cer',
    ],
    'ionic'    => [
        'app_id'     => 'ee60e96a',
        'app_secret' => '9b2ce71b9906a0165b782799ed1261efc4293c6cd895de7f',
    ],

];
