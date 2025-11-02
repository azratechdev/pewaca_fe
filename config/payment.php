<?php

return [
    'provider' => env('PAYMENT_PROVIDER', 'mock'),
    
    'provider_api_key' => env('PAYMENT_PROVIDER_API_KEY', ''),
    
    'provider_api_url' => env('PAYMENT_PROVIDER_API_URL', ''),
    
    'webhook_secret' => env('PAYMENT_WEBHOOK_SECRET', 'mock_secret_key_12345'),
    
    'callback_signing_key' => env('PAYMENT_CALLBACK_SIGNING_KEY', 'callback_secret_key_67890'),
    
    'expire_minutes' => env('PAYMENT_EXPIRE_MINUTES', 15),
    
    'rate_limit' => [
        'requests' => env('PAYMENT_RATE_LIMIT_REQUESTS', 10),
        'per_minutes' => env('PAYMENT_RATE_LIMIT_MINUTES', 1),
    ],
];
