<?php

declare(strict_types=1);

return [
    'email' => env('PANDLE_EMAIL'),
    'password' => env('PANDLE_PASSWORD'),
    'baseUrl' => env('PANDLE_BASE_URL', 'https://my.pandle.com/api/v1'),
    'cache' => [
        'enabled' => env('PANDLE_CACHE_ENABLED', false),
        'store' => env('PANDLE_CACHE_STORE', 'database'),
        'key' => env('PANDLE_CACHE_KEY', 'pandle'),
    ],
];
