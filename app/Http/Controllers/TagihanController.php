<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class TagihanController extends Controller
{
    public function list()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan/');
    
            $data_response = json_decode($response->body(), true);

            if ($response->successful()) {
                return view('pengurus.tagihan.list', compact('data'));
            } else {
               
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
            }
        } catch (\Exception $e) {
          
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan',
                'alert-class' => 'alert-error',
            ]);
            
        }
    }

    

    public function addTagihan()
    {
        //dd(session::get('cred')['user_id']);
        return view('pengurus.tagihan.add');
       
    }

    public function publish(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|string',
            '_token' => 'required|string',
        ]);

        $id = $request->tagihan_id;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->post('https://api.pewaca.id/api/tagihan/publish-tagihan/' . $id . '/');

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($data_response['success'] == true) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tagihan berhasil dipublish.',
                    'data' => $data_response['data'], // Opsional, jika ada data tambahan
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mempublish tagihan.',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server.',
            ], 500);
        }
    }

    public function editTagihan($id)
    {
        //dd($id);
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan/'.$id.'/');
    
            $data_response = json_decode($response->body(), true);

            //dd($data_response);
    
            if ($response->successful()) {
                $tagihan = $data_response['data'];
                //dd($tagihan);
                return view('pengurus.tagihan.edit', compact('tagihan'));
            } else {
               
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('tagihan.edit', ['id' => $id]);
            }
        } catch (\Exception $e) {
           
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('tagihan.edit', ['id' => $id]);
        }
    }

    public function postEditTagihan(Request $request)
    {
        //dd($request->all());
        // Validasi dan update data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

       // $tagihan->update($validatedData);

        // Redirect ke halaman edit
        return redirect()->route('tagihan.edit', ['id' => $request->tagihan_id])
                        ->with('success', 'Tagihan berhasil diperbarui.');
    }


    public function postTagihan(Request $request)
    {
      // dd($request->all());
       $request->validate([
        'repeat' => 'nullable|string',
        'nominal' => 'required|string',
        'nama_tagihan' => 'required|string',
        'type_iuran' => 'required|string',
        'deskripsi' => 'required|string',
        'periode' => 'nullable|string', // Bisa berupa rentang tanggal
        // 'jatuh_tempo' => 'nullable|string',
        // 'durasi_tagihan' => 'required|string',
         
        ]);
        
        $nominal_original_format = $this->formatNominal($request->nominal);
       

        $from_date = null;
        $due_date = null;
        
         
        if ($request->filled('from_date')) {
            $from_date = $request->from_date;
        }
        
        // Jika repeat diaktifkan, gunakan periode
        if ($request->filled('periode')) {
            $tgl = explode(' to ', $request->periode);
            //dd($tgl);
            $from_date = $tgl[0] ?? null; // Hindari error jika tidak ada rentang
            $due_date = $tgl[1] ?? null;
        }
       
        if ($request->filled('jatuh_tempo')) {
            $due_date = $request->jatuh_tempo;
        } 

        // $data = [
        //     'name' => $request->nama_tagihan,
        //     'description' => $request->deskripsi,
        //     'tipe' => $request->type_iuran,
        //     'tempo' => $request->jatuh_tempo,
        //     'amount' => $nominal_original_format,
        //     'duration' => $request->durasi_tagihan,
        // ];
                             
        $data = [
            'jenis_tagihan' => $request->repeat,
            'amount' => $nominal_original_format,
            'date_due' => $due_date,
            'name' => $request->nama_tagihan,
            'tipe' => $request->type_iuran,
            'description' => $request->deskripsi,
            'from_date' => $from_date,
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
                Session::flash('flash-message', [
                    'message' => 'Periksa Data Kembali',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('tagihan.add');
            }
        } catch (\Exception $e) {
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
   
    public function approvalDetail($id)
    {
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan-warga/'.$id.'/');
        $tagihan_response = json_decode($response->body(), true);
        $data =  $tagihan_response['data'];
        
        //dd($data);

        return view('pengurus.tagihan.detail_approval', compact('data'));
       
    }


}
