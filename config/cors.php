<?php

use Illuminate\Support\Str;

return [
    'paths' => ['api/*', 'register', 'login'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];