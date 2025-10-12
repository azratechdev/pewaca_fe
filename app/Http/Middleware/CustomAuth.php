<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CustomAuth
{
    public function handle($request, Closure $next)
    {
        try {
            Log::info('CustomAuth Middleware - Route: ' . $request->path());
            Log::info('CustomAuth Middleware - Session ID: ' . (Session::getId() ?? 'null'));
            Log::info('CustomAuth Middleware - Has cred: ' . (Session::has('cred') ? 'Yes' : 'No'));
            
            // ✅ Safe session keys logging
            $sessionData = Session::all();
            $sessionKeys = is_array($sessionData) ? array_keys($sessionData) : [];
            Log::info('CustomAuth Middleware - All session keys: ' . implode(', ', $sessionKeys));
            
            // Skip auth check for media routes
            if ($request->is('media/*')) {
                Log::info('CustomAuth Middleware - Skipping auth for media route');
                return $next($request);
            }
            
            // Skip auth check for login form routes
            if ($request->routeIs('showLoginForm') || $request->routeIs('postlogin')) {
                Log::info('CustomAuth Middleware - Skipping auth for login routes');
                return $next($request);
            }
            
            // Skip auth check for login in progress (has token but no cred yet)
            if (Session::has('token') && !Session::has('cred')) {
                Log::info('CustomAuth Middleware - Login in progress, allowing request to proceed');
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
            $allowedRoutes = ['log_out', 'home', 'akun'];

            // ✅ Safe permission checking with null safety
            if (
                is_array($user) && isset($user['is_pengurus']) && !$user['is_pengurus'] &&
                is_array($warga) && isset($warga['is_checker']) && !$warga['is_checker'] &&
                $request->route() && // ✅ Ensure route exists
                !in_array($request->route()->getName(), $allowedRoutes)
            ) {
                return redirect()->route('home');
            }
      
            // ✅ Safe route name logging
            $routeName = $request->route() ? $request->route()->getName() : 'unknown';
            Log::info('CustomAuth Middleware - Access granted for route: ' . $routeName);
            return $next($request);
            
        } catch (\Exception $e) {
            Log::error('CustomAuth Middleware Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Fallback - redirect to login if middleware fails
            return redirect()->route('showLoginForm');
        }
    }
}
