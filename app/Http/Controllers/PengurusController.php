<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengurusController extends Controller
{
    public function index()
    {
        $data_warga = $this->getWarga();
        //dd('DATA WARGA', $data_warga);
        return view('pengurus.index', compact('data_warga'));
    }


    public function getWarga()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get('https://api.pewaca.id/api/warga/');
               
            $warga_response = json_decode($response->body(), true);
            //dd($warga_response);
            if (isset($warga_response['data'])) {
                $data = $warga_response['data'];
                //dd($data);
                $warga = [
                    'data' => $data,
                    'message' => ''
                ];
                //dd($warga);
            }
            else{
                $warga = [
                    'data' => [],
                    'message' => 'No data found'
                ];
            }
           
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data warga',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pengurus');
        }

        return $warga;
    }

}
