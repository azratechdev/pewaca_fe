<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class TagihanController extends Controller
{
    public function list()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get(env('API_URL') . '/api/tagihan/');
    
            $data_response = json_decode($response->body(), true);

            if ($response->successful() && isset($data_response['data'])) {
                $data_tagihan = $data_response['data'];
                return view('pengurus.tagihan.list', compact('data_tagihan'));
            } else {
               
                Session::flash('flash-message', [
                    'message' => 'Data tidak ditemukan',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
          
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data tagihan: ' . $e->getMessage(),
                'alert-class' => 'alert-error',
            ]);
            return redirect()->route('home');
        }
    }

    

    public function addTagihan()
    {
        //dd(session::get('cred')['user_id']);
        return view('pengurus.tagihan.add');
       
    }

    public function publish(Request $request)
    {
        error_log("=== PUBLISH TAGIHAN DEBUG (error_log) ===");
        
        $request->validate([
            'tagihan_id' => 'required|string',
            '_token' => 'required|string',
        ]);

        $id = $request->tagihan_id;
        
        error_log("Tagihan ID: " . $id);

        try {
            Log::info('=== PUBLISH TAGIHAN DEBUG ===');
            Log::info('Tagihan ID:', ['id' => $id]);
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->post(env('API_URL') . '/api/tagihan/publish-tagihan/' . $id . '/');

            $data_response = json_decode($response->body(), true);

            \Log::info('Publish Response Status:', ['status' => $response->status()]);
            \Log::info('Publish Response Body:', ['body' => $response->body()]);
            \Log::info('Parsed Response:', ['parsed' => $data_response]);

            if ($data_response['success'] == true) {
                \Log::info('Publish Success', ['tagihan_id' => $id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Tagihan berhasil dipublish.',
                    'data' => $data_response['data'],
                ], 200);
            } else {
                \Log::error('Publish Failed', [
                    'tagihan_id' => $id,
                    'response' => $data_response
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mempublish tagihan.',
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Publish Exception', [
                'tagihan_id' => $id,
                'error' => $e->getMessage()
            ]);
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
            ])->get(env('API_URL') . '/api/tagihan/'.$id.'/');
    
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
            'date_start' => $from_date,  // Fixed: changed from_date to date_start
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
            ])->post(env('API_URL') . '/api/tagihan/', $data);
    
            $data_response = json_decode($response->body(), true);

            \Log::info('=== POST TAGIHAN DEBUG ===');
            \Log::info('Request Data:', $data);
            \Log::info('Response Status:', ['status' => $response->status()]);
            \Log::info('Response Body:', ['body' => $response->body()]);
            \Log::info('Parsed Response:', ['parsed' => $data_response]);
    
            if ($response->successful()) {
                Session::flash('flash-message', [
                    'message' => 'Add Tagihan Success',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('tagihan.add');
            } else {
                // Get error message from API response
                $errorMsg = 'Periksa Data Kembali';
                if (isset($data_response['error'])) {
                    $errorMsg .= ': ' . (is_array($data_response['error']) ? json_encode($data_response['error']) : $data_response['error']);
                } elseif (isset($data_response['message'])) {
                    $errorMsg .= ': ' . $data_response['message'];
                }
                
                \Log::error('Post Tagihan Failed:', [
                    'status' => $response->status(),
                    'error' => $errorMsg
                ]);
                
                Session::flash('flash-message', [
                    'message' => $errorMsg,
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
        ])->get(env('API_URL') . '/api/tagihan-warga/'.$id.'/');
        $tagihan_response = json_decode($response->body(), true);
        $data =  $tagihan_response['data'];
        
        //dd($data);

        return view('pengurus.tagihan.detail_approval', compact('data'));
       
    }


}
