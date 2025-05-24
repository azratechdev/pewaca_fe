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
        $data_approved = $this->getApproved();
        //dd($data_approved);
        $warga_id = session::get('cred')['residence_commites'][0]['warga'];
        //$residence_id = session::get('cred')['residence_commites'][0]['residence'];
        return view('pembayaran.index', compact('data_tagihan', 'data_approved', 'warga_id'));
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
  
    public function list_tagihan(Request $request)
    {
        //dd(session::all());
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/tagihan-warga/self-list/?status=unpaid,process&page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $tagihan_response = json_decode($response->body(), true);
        //dd($tagihan_response);
      
        $data_tagihan = $tagihan_response['data'] ?? [];
        $next_page = $tagihan_response['next'] ?? null;
        $previous_page = $tagihan_response['previous'] ?? null;

        if(isset($tagihan_response['count'])){
            $count = $tagihan_response['count'];
        }
        else{
            $count = 5;
        }

        $total_pages = (int) ceil($count / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=explode('&', $p[1]);
            $next=$next[0];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=explode('&', $p[1]);
                $prev=$prev[0];
            }
            
        }
        
        
        return view('pembayaran.list_pembayaran', compact('data_tagihan','current','next','prev','next_page','previous_page', 'total_pages'));
       
    }

    public function list_history (Request $request)
    { //dd(session::get('warga')['id']);
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/tagihan-warga/self-list/?status=paid&page='.$page.'&warga_id='.session::get('warga')['id'];

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $tagihan_response = json_decode($response->body(), true);
        
        //dd($tagihan_response);
      
        $data_tagihan = $tagihan_response['data'] ?? [];
        $next_page = $tagihan_response['next'] ?? null;
        $previous_page = $tagihan_response['previous'] ?? null;

        if(isset($tagihan_response['count'])){
            $count = $tagihan_response['count'];
        }
        else{
            $count = 5;
        }

        $total_pages = (int) ceil($count / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=explode('&', $p[1]);
            $next=$next[0];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=explode('&', $p[1]);
                $prev=$prev[0];
            }
            
        }
        //dd(session::get('warga'));
        // if(!empty(session::get('cred')['residence_commites'])){
        //     $warga_id = session::get('cred')['residence_commites'][0]['warga'];
        // }
        // else{
        //     $warga_id = session::get('warga')['id'];
        // }

        //dd($data_tagihan);
       

        return view('pembayaran.list_history', compact('data_tagihan','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function list_postingan(Request $request)
    {
         return view('pembayaran.list_postingan');
    }

    
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
    {   //dd('HEREEE');
        //dd($id);
       
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan-warga/'.$id.'/');
    
            $data_response = json_decode($response->body(), true);

            $getnote = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan-note/list/'.$id.'/');
    
            $data_note = json_decode($getnote->body(), true);
    
            if ($response->successful()) {
                $tagihan = $data_response;
                $warga_id =session::get('warga')['id'];
                $ceknote = false;
                if (!empty($data_note['data']) && count($data_note['data']) === 1) {
                    $ceknote = true;
                }
              
                return view('pembayaran.uploadbuktipage', compact('warga_id', 'tagihan', 'ceknote'));
                
                
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

    public function postNote(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tagihan_warga_id' => 'required|string',
            'warga_id' => 'required|string'
        ]);
            
        try {
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token ' . session::get('token'),
            ]);
        
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $http->attach(
                    'images', 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName()
                );
            }
        
            $http->attach(
                'note', 
                $request->note
            )->attach(
                'tagihan_warga',
                $request->tagihan_warga_id
            )->attach(
                'warga',
                $request->warga_id
            );
        
            $response = $http->post('https://api.pewaca.id/api/tagihan-note/create-note/');
            $data_response = json_decode($response->body(), true);
            //dd($data_response);
          
            if ($data_response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Catatan berhasil dikirim',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('pembayaran.detail_bukti', ['id' => $request->tagihan_warga_id]);
            } else {
                Session::flash('flash-message', [
                    'message' => 'Catatan gagal dikirim',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('pembayaran.upload_bukti', ['id' => $request->tagihan_warga_id]);
            }
            
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data niiihh',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.upload_bukti', ['id' => $request->tagihan_warga_id]);
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
    
            $data_note = json_decode($response->body(), true);

            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'),
            ])->get('https://api.pewaca.id/api/tagihan-warga/'.$id.'/');
    
            $data_tagihan = json_decode($res->body(), true);
                
            if ($response->successful()) {
                $list = $data_note['data'];
                //dd($list);
                $id = $id;
                $status = $data_tagihan['data']['status'];
                //dd($list);
                return view('pembayaran.detailpembayaran', compact('list', 'id', 'status'));
            }
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal mengambil data bukti pembayaran',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('pembayaran.detailpembayaran', ['id' => $id]);
        }
    }

    public function getApproved()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan-warga/self-list/?status=paid');
        $tagihan_response = json_decode($response->body(), true);
        return $tagihan_response;
    }

    public function formatNominal($nominal)
    {
        // Hapus simbol mata uang, spasi, dan titik
        $formatted = preg_replace('/[^\d]/', '', $nominal);
        // Kembalikan nilai sebagai integer
        return (int) $formatted;
    }

}
