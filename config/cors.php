<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Laravel CORS Defaults
     |--------------------------------------------------------------------------
     |
     | The defaults are the default values applied to all the paths that match,
     | unless overridden in a specific URL configuration.
     | If you want them to apply to everything, you must define a path with *.
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*') 
     | to accept any value, the allowed methods however have to be explicitly listed.
     |
     */
    'defaults' => [
        'supportsCredentials' => false,
        'allowedOrigins'      => [],
        'allowedHeaders'      => [],
        'allowedMethods'      => [],
        'exposedHeaders'      => [],
        'maxAge'              => 0,
        'hosts'               => [],
    ],
    'paths'    => [
        'webhooks/*' => [
            'allowedOrigins' => ['*'],
            'allowedHeaders' => ['*'],
            'allowedMethods' => ['*'],
            'maxAge'         => 3600,
        ],
    ],

];
