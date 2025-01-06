<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class TagihanController extends Controller
{
    public function list(Request $request)
    {
        $data = "1234";
        
        return view('pengurus.tagihan.list', compact('data'));
    }

    public function addTagihan()
    {
        //dd(session::get('cred')['user_id']);
        return view('pengurus.tagihan.add');
       
    }

    public function postTagihan(Request $request)
    {
       
        $request->validate([
            'nama_tagihan' => 'required|string',
            'deskripsi' => 'required|string',
            'type_iuran' => 'required|string',
            'from_date' => 'required|date',
            'due_date' => 'required|date',
            'nominal' => 'required|string',
            'repeat' => 'required|string',
        ]);

        $nominal_original_format = $this->formatNominal($request->nominal);

        $data = [
            'jenis_tagihan' => $request->repeat,
            'amount' => $nominal_original_format,
            'date_due' => $request->due_date,
            'name' => $request->nama_tagihan,
            'tipe' => $request->type_iuran,
            'description' => $request->deskripsi,
            'from_date' => $request->from_date,
            // 'is_publish' => false,
            // 'publish_date' => now()->format('Y-m-d H:i:s'),
            // 'create_at' => now()->format('Y-m-d H:i:s'),
            // 'created_by' => session::get('cred')['user_id'],
            // 'residence' => 'test'
                     
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
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->post('https://api.pewaca.id/api/tagihan/', $data);
    
            $data_response = json_decode($response->body(), true);

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

    public function formatNominal($nominal)
    {
        // Hapus simbol mata uang, spasi, dan titik
        $formatted = preg_replace('/[^\d]/', '', $nominal);
        // Kembalikan nilai sebagai integer
        return (int) $formatted;
    }
   


}
