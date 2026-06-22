<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000')),

    // Allows any tenant subdomain (e.g. http://acme.localhost:3000) as a CORS origin.
    'allowed_origins_patterns' => [
        env('CORS_ALLOWED_ORIGIN_PATTERN', '#^https?://([a-z0-9-]+\.)?localhost(:\d+)?$#'),
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
