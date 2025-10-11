<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CustomAuth
{
    public function handle($request, Closure $next)
    {
        Log::info('CustomAuth Middleware - Route: ' . $request->path());
        Log::info('CustomAuth Middleware - Session ID: ' . Session::getId());
        Log::info('CustomAuth Middleware - Has cred: ' . (Session::has('cred') ? 'Yes' : 'No'));
        Log::info('CustomAuth Middleware - All session keys: ' . implode(', ', array_keys(Session::all())));
        
        // Skip auth check for media routes
        if ($request->is('media/*')) {
            Log::info('CustomAuth Middleware - Skipping auth for media route');
            return $next($request);
        }
        
        // Memeriksa apakah data user ada di sesi
        if (!Session::has('cred')) {
            Log::info('CustomAuth Middleware - No cred found, redirecting to login');
            return redirect()->route('showLoginForm');
        }

        // Mendapatkan data dari session
        $user = Session::get('cred'); // Data user
        $warga = Session::get('warga'); // Data warga

        // Daftar rute yang boleh diakses
        $allowedRoutes = ['log_out', 'home', 'akun']; // Tambahkan rute logout di sini

        // Jika bukan pengurus dan is_checker = false, redirect ke home
        if (
            !$user['is_pengurus'] &&
            isset($warga['is_checker']) &&
            !$warga['is_checker'] &&
            !in_array($request->route()->getName(), $allowedRoutes)
        ) {
            return redirect()->route('home');
        }

        // Jika user adalah pengurus, abaikan pengecekan `is_checker`
        // if (isset($user['is_pengurus']) && $user['is_pengurus']) {
        //     return $next($request);
        // }

        // // Jika user bukan pengurus dan `is_checker` false, arahkan ke home
        // if (isset($warga['is_checker']) && !$warga['is_checker']) {
        //     return redirect()->route('home');
        // }
  
        Log::info('CustomAuth Middleware - Access granted for route: ' . $request->route()->getName());
        return $next($request);
    }
}
