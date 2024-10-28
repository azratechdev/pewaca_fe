<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AkunController extends Controller
{
    public function akun()
    {
        return view('akun.index');
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
