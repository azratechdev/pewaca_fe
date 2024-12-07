<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengurusController extends Controller
{
    public function index()
    {
        
        $peoples = $this->getWarga(); 
        //dd($peoples);
        return view('pengurus.index', compact('peoples'));
    }

    public function getWarga()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/');
        $warga_response = json_decode($response->body(), true);
     
        return  $warga_response['data'];
       
    }


}
