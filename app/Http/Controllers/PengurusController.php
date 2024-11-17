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
        //$data_warga = ['data' => [], 'message' => 'data kosong'];
        return view('pengurus.index', compact('data_warga'));
    }

    public function getWarga()
    {
        try {
            // Mengambil data menggunakan Http::get()
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get('https://api.pewaca.id/api/warga/');

            // Mengecek apakah status HTTP adalah 200 OK
            if ($response->successful()) {
                // Menggunakan json_decode untuk parsing JSON
                $warga_response = json_decode($response->body(), true);
                
                // Mengecek apakah data ada dalam response
                if (isset($warga_response['data'])) {
                    $data = $warga_response['data'];
                    
                    // Mengembalikan data warga atau pesan jika kosong
                    return [
                        'data' => $data,
                        'message' => $data ? '' : 'No data found'
                    ];
                } else {
                    return [
                        'data' => [],
                        'message' => 'No data found in response'
                    ];
                }
            } else {
                // Jika status HTTP tidak sukses, beri pesan error
                return [
                    'data' => [],
                    'message' => 'Failed to fetch data from API. HTTP Status: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            // Menangani error lain, misalnya masalah koneksi API
            return [
                'data' => [],
                'message' => 'Error occurred: ' . $e->getMessage()
            ];
        }
    }


}
