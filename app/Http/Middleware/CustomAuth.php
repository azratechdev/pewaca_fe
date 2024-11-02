<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CustomAuth
{
    public function handle($request, Closure $next)
    {
        // Memeriksa apakah data user ada di sesi
        if (!Session::has('cred')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
