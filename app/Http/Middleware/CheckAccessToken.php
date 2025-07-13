<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CheckAccessToken
{
    public function handle($request, Closure $next)
    {
        $token = Session::get('token');
        $refreshToken = Session::get('refresh_token');
        $createdAt = Session::get('token_created_at');

        // Hitung durasi access token, misal 3 hari
        if ($token && $createdAt && Carbon::parse($createdAt)->addDays(3)->isPast()) {
            // Token expired → refresh
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api.pewaca.id/api/auth/token/refresh/', [
                'refresh' => $refreshToken
            ]);

            if ($response->successful()) {
                $newToken = $response->json()['access'];
                Session::put('token', $newToken);
                Session::put('token_created_at', now());
            } else {
                // Refresh gagal → paksa logout
                Session::flush();
                return redirect()->route('showLoginForm')->withErrors(['Session expired. Please login again.']);
            }
        }

        return $next($request);
    }
}
