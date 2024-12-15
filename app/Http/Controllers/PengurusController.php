<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
       
        $people_false = $this->getWargaFalse(); 

        //dd($people_false);
        $people_true = $this->getWargaTrue();
        //dd($people_true);
        return view('pengurus.index', compact('people_false', 'people_true'));
    }

    public function getWargaFalse()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?page=1&is_checker=false');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['data'];
       
    }

    public function getWargaTrue()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?page=1&is_checker=true');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['data'];
       
    }


}
