<?php

return [
    'name' => 'Pewaca',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'PWA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '750x1334' => '/images/icons/splash-750x1334.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Pewaca',
                'description' => 'Pewaca Application',
                'url' => '/pewaca',
                'icons' => [
                    "src" => "/images/icons/icon-192x192.png",
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => []
    ]
];
