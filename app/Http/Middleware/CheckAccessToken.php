<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckAccessToken
{
    public function handle($request, Closure $next)
    {
        $token = Session::get('token');
        $refreshToken = Session::get('refresh_token');
        $createdAt = Session::get('token_created_at');
        
        Log::info('CheckAccessToken Middleware - Route: ' . $request->path());
        Log::info('CheckAccessToken Middleware - Has token: ' . ($token ? 'Yes' : 'No'));
        Log::info('CheckAccessToken Middleware - Created at: ' . $createdAt);

        // Jika token ada
        if ($token && $createdAt) {
            $expired = Carbon::parse($createdAt)->addDays(3)->isPast();
            Log::info('CheckAccessToken Middleware - Token expired: ' . ($expired ? 'Yes' : 'No'));

            // ✅ Token masih berlaku
            if (! $expired) {
                if ($request->is('/') || $request->routeIs('showLoginForm')) {
                    // Only redirect to home if we also have cred data
                    if (Session::has('cred')) {
                        Log::info('CheckAccessToken Middleware - Redirecting to home from login page');
                        return redirect()->route('home');
                    } else {
                        Log::info('CheckAccessToken Middleware - Token valid but no cred data yet, allowing request');
                        return $next($request);
                    }
                }
                Log::info('CheckAccessToken Middleware - Token valid, proceeding');
                return $next($request);
            }

            // ❌ Token expired → coba refresh
            if ($expired && $refreshToken) {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post(env('API_URL') . '/api/auth/token/refresh/', [
                    'refresh' => $refreshToken
                ]);

                if ($response->successful()) {
                    $newToken = $response->json()['data']['token'];
                    Session::put('token', $newToken);
                    Session::put('token_created_at', now());

                    if ($request->is('/') || $request->routeIs('showLoginForm')) {
                        // Only redirect to home if we also have cred data
                        if (Session::has('cred')) {
                            return redirect()->route('home');
                        } else {
                            return $next($request);
                        }
                    }
                    return $next($request);
                }

                // Refresh gagal → logout
                Session::flush();
                return redirect()->route('showLoginForm')
                    ->withErrors(['Session expired. Please login again.']);
            }
        }

        // Jika tidak ada token sama sekali → arahkan ke login
        if (! $request->routeIs('showLoginForm')) {
            return redirect()->route('showLoginForm');
        }

        return $next($request);
    }
}


// class CheckAccessToken
// {
//     public function handle($request, Closure $next)
//     {
//         $token = Session::get('token');
//         $refreshToken = Session::get('refresh_token');
//         $createdAt = Session::get('token_created_at');

//         // kalau token ada & belum expired → langsung redirect ke home
//         if ($token && $createdAt && !Carbon::parse($createdAt)->addDays(3)->isPast()) {
//             // cek apakah user sedang akses halaman login
//             if ($request->is('/') || $request->routeIs('showLoginForm')) {
//                 return redirect()->route('home');
//             }
//         }

//         // kalau token expired → coba refresh
//         if ($token && $createdAt && Carbon::parse($createdAt)->addDays(3)->isPast()) {
//             $response = Http::withHeaders([
//                 'Accept' => 'application/json',
//                 'Content-Type' => 'application/json',
//             ])->post(env('API_URL') . '/api/auth/token/refresh/', [
//                 'refresh' => $refreshToken
//             ]);

//             if ($response->successful()) {
//                 $newToken = $response->json()['access'];
//                 Session::put('token', $newToken);
//                 Session::put('token_created_at', now());

//                 // kalau user lagi buka login, setelah refresh juga langsung ke home
//                 if ($request->is('/') || $request->routeIs('showLoginForm')) {
//                     return redirect()->route('home');
//                 }
//             } else {
//                 Session::flush();
//                 return redirect()->route('showLoginForm')->withErrors(['Session expired. Please login again.']);
//             }
//         }

//         return $next($request);
//     }

// }
