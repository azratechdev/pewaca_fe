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
        ])->get('https://api.pewaca.id/api/tagihan-warga/self-list/?status=unpaid,process');
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
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('pembayaran.addpembayaran', ['id' => $id]);
            }
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.add', ['id' => $id]);
        }
    }

    public function uploadbukti($id)
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
                return view('pembayaran.uploadbuktipage', compact('tagihan'));
            } else {
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('pembayaran.uploadbuktipage', ['id' => $id]);
            }
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.uploadbuktipage', ['id' => $id]);
        }
               
    }

    public function postPembayaran(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nominal' => 'required|string',
            'residence_bank' => 'required|string',
            'tagihan_id' => 'required|string'
        ]);
        //dd('here');
        $nominal_original_format = $this->formatNominal($request->nominal);
        
        try {
                   
            $http = Http::withHeaders([
                'Accept' => 'application/json', // Header untuk menerima JSON
                'Authorization' => 'Token ' . session::get('token'),
            ]);
        
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $http->attach(
                    'bukti_pembayaran', 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName()
                );
            }
        
            $data = [
                'amount' => $nominal_original_format,
                'residence_bank' => $request->residence_bank,
                'note' => $request->note,
                // 'id' => $request->tagihan_id
            ];
        
            $response = $http->patch(
                'https://api.pewaca.id/api/tagihan-warga/bayar/' . $request->tagihan_id . '/',
                $data
            );
        
            $data_response = json_decode($response->body(), true);
            //dd($data_response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Bukti pembayaran berhasil diunggah',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('pembayaran.detail_bukti', ['id' => $request->tagihan_id]);
            } else {
                Session::flash('flash-message', [
                    'message' => 'Bukti pembayaran gagal diunggah',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('pembayaran.upload_bukti', ['id' => $request->tagihan_id]);
            }
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.upload_bukti', ['id' => $request->tagihan_id]);
        }
    }

    public function detailPembayaran($id)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan-note/list/'.$id.'/');
    
            $data_response = json_decode($response->body(), true);

            //dd($data_response);
                
            if ($response->successful()) {
                $list = $data_response['data'];
                $id = $id;
                //dd($list);
                return view('pembayaran.detailpembayaran', compact('list', 'id'));
            }
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data bukti pembayaran',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.detailpembayaran', ['id' => $id]);
        }
    }

    public function formatNominal($nominal)
    {
        // Hapus simbol mata uang, spasi, dan titik
        $formatted = preg_replace('/[^\d]/', '', $nominal);
        // Kembalikan nilai sebagai integer
        return (int) $formatted;
    }

}
