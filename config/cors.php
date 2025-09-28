<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],

    'allowed_origins' => [
    'http://43.156.75.206',
    'http://43.156.75.206:9001',
    'https://pewaca.id',
    'http://localhost',
    'http://localhost:9000'],

    'allowed_origins_patterns' => [],

    // Headers allowed in the API requests
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept'],

    'exposed_headers' => ['Authorization'],

    'max_age' => 3600,

    'supports_credentials' => true,

];
