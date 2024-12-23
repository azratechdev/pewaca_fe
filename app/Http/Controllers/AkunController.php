<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class AkunController extends Controller
{
    public function akun()
    {
        $user = Session::get('cred');
        $warga = Session::get('warga');
        //dd($user);
        return view('akun.akunpage', compact('user', 'warga'));
    }

    public function infoakun()
    {   
        // $user = Session::get('cred');
        // $warga = Session::get('warga');
        // $residence = Session::get('residence');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/auth/profil/');
        $warga_response = json_decode($response->body(), true);
        $data = $warga_response['data'];
        //dd($data);
        return view('akun.akuninfo', compact('data'));
    }

    public function inforekening()
    {   
        $user = Session::get('cred');
        $warga = Session::get('warga');
        $residence = Session::get('residence');
        return view('akun.rekeninginfo', compact('user', 'warga', 'residence'));
    }

    public function infokeluarga()
    {   
        $user = Session::get('cred');
        $warga = Session::get('warga');
        $residence = Session::get('residence');
        return view('akun.familyinfo', compact('user', 'warga', 'residence'));
    }

    public function edit()
    {
        return view('akun.editakun');
    }

    public function registrasi()
    {
        return view('akun.registrasi');
    }

}
