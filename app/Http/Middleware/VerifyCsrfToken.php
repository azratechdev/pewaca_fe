<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'login',        // POST /login
        '/login',       // jaga-jaga
        '/',            // POST /
        'debug/login',  // Debug login endpoint (testing)
    ];
}
