<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Ambil data pengguna dari session atau cara lain yang digunakan untuk menyimpan data
        $userData = Session::get('cred'); // Pastikan data dari API disimpan di session 'cred'
       
        if ($userData && isset($userData['residence_commites'])) {
            // $hasRole = collect($userData['residence_commites'])->contains('role', $this->getRoleId($role));
            // Cek apakah ada role yang sesuai di residence_commites
            foreach ($userData['residence_commites'] as $commite) {
                if (isset($commite['role']['id'])) {
                    // Role sesuai, lanjutkan request
                    return $next($request);
                }
            }
            // // Jika pengguna memiliki peran yang sesuai, lanjutkan
            // if ($hasRole) {
            //     return $next($request);
            // }
        }

        // Arahkan kembali jika tidak memiliki akses
        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Metode untuk mendapatkan role_id berdasarkan nama peran
    protected function getRoleId($roleName)
    {
        $roles = [
            'pengurus' => 1,
            'warga' => 2,
        ];

        return $roles[$roleName] ?? null;
    }
}
