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
        'model'     => 'App\User',
        'secret'    => 'sk_live_xATLLmS3513U0kgZISnLfTWA',
        'client_id' => 'ca_7hpAb8673Ng1S6KbWHCGTuwhNZVeJHkX'
    ],
    'xero'     => [
        'application_type'    => "Private",
        'oauth_callback'      => "oob",
        'user_agent'          => "XeroOAuth-PHP Private Koolbeans",
        'consumer_key'        => '1QQJX68CT8BXFQ2NTS308E8YPQELDY',
        'access_token'        => '1QQJX68CT8BXFQ2NTS308E8YPQELDY',
        'shared_secret'       => 'B1MJCBUP451N9N18RBB13GHTA1Z52H',
        'access_token_secret' => 'B1MJCBUP451N9N18RBB13GHTA1Z52H',
        'core_version'        => '2.0',
        'payroll_version'     => '1.0',
        'file_version'        => '1.0',
        'rsa_private_key'     => '/var/www/keys/kbprivate.pem',
        'rsa_public_key'      => '/var/www/keys/kbpublic.cer',
        // 'rsa_private_key'     => '/etc/ssl/certs/koolbeans.pem',
        // 'rsa_public_key'      => '/etc/ssl/certs/koolbeans.cer',
    ],
    'ionic'    => [
        'app_id'     => 'ef4727c0',
        'app_secret' => 'f73be765e4d464e4aa8529739a7ffdf17d50bd28b54f6db7',
    ],

];
