<?php

return [
    'default' => env('CACHE_STORE', 'file'),
    'stores' => [
        'file' => ['driver' => 'file', 'path' => storage_path('framework/cache/data')],
        'array' => ['driver' => 'array'],
    ],
    'prefix' => env('CACHE_PREFIX', 'university_portal_cache'),
];
