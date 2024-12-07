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
  

        return $next($request);
    }
}
