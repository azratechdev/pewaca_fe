<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PembayaranController extends Controller
{
    public function index()
    {   
        $data_tagihan = $this->getTagihan();
        //dd($data_tagihan);
        return view('pembayaran.index', compact('data_tagihan'));
    }

    public function getTagihan()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan-warga/?status=waiting payment');
        $tagihan_response = json_decode($response->body(), true);
        return $tagihan_response;
    }
  
    // public function list()
    // {
    //     try {
    //         $response = Http::withHeaders([
    //             'Accept' => 'application/json',
    //             'Content-Type' => 'application/json',
    //             'Authorization' => 'Token ' . Session::get('token'),
    //         ])->get('https://api.pewaca.id/api/tagihan-warga/?status=unpaid');
    
    //         $data_response = json_decode($response->body(), true);
    //         $data_tagihan = $data_response;
    //         if ($response->successful()) {
    //             return view('pembayaran.listpembayaran', compact('data_tagihan'));
    //         } else {
    //             \Log::warning('Response Error', [
    //                 'status' => $response->status(),
    //                 'body' => $response->body(),
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         \Log::error('Gagal mendapatkan data tagihan', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //     }
    // }

    
    public function addpembayaran($id)
    {
        
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan-warga/'.$id.'/');
    
            $data_response = json_decode($response->body(), true);

            //dd($data_response);
    
            if ($response->successful()) {
                $tagihan = $data_response;
                return view('pembayaran.addpembayaran', compact('tagihan'));
            } else {
                Log::warning('Response Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('pembayaran.addpembayaran', ['id' => $id]);
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data tagihan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
    
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.add', ['id' => $id]);
        }

       
       
    }

    public function postPembayaran(Request $request)
    {
        dd($request->all());
        $request->validate([
            'tagihan_id' => 'required|string',
            'amount' => 'required|number',
            'residence_bank' => 'required|number',
            'post_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $nominal_original_format = $this->formatNominal($request->nominal);

        $data = [
            'residence_bank' => $request->residence_bank,
            'amount' => $nominal_original_format,
            'tagihan_id' => $request->tagihan_id,
        ];

        //dd($data);
        if (!Session::has('token')) {
            Session::flash('flash-message', [
                'message' => 'Token tidak tersedia, silakan login ulang.',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('tagihan.add');
        }

        try {
            

            //dd($data_response);
    
            if ($response->successful()) {
                Session::flash('flash-message', [
                    'message' => 'Add Tagihan Success',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('tagihan.add');
            } else {
                \Log::warning('Response Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                Session::flash('flash-message', [
                    'message' => 'Periksa Data Kembali',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('tagihan.add');
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim data tagihan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
    
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('tagihan.add');
        }
    }

}
