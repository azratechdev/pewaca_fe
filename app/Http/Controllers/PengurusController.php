<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        return view('pengurus.index');
    }

    public function pengurus_tagihan(Request $request)
    {
        $data_tagihan = $this->getTagihan();
        $data_confirm = $this->list_confirm();
        $data_approved = $this->list_approved();
        //dd($data_confirm);
        return view('pengurus.tagihan.tagihan_menu', compact('data_tagihan', 'data_confirm', 'data_approved'));
    }

    public function pengurus_role(Request $request)
    {

        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/residence-commite/?page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $warga_response = json_decode($response->body(), true);
        //dd($warga_response);
      
        $pengurus = $warga_response['results'] ?? [];
        $next_page = $warga_response['next'] ?? null;
        $previous_page = $warga_response['previous'] ?? null;

        if($warga_response){
            $total_pages = (int) ceil($warga_response['count'] / 10);
        }
        else {
            $total_pages = (int) 1;
        }
       
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }
       
        return view('pengurus.role.list_role', compact('pengurus','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    // public function getPengurus()
    // {
    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Authorization' => 'Token '.Session::get('token'),
    //     ])->get('https://api.pewaca.id/api/residence-commite/');
    //     $warga_response = json_decode($response->body(), true);
    //     return  $warga_response;
    // }

    public function pengurus_warga()
    {
        $people_false = $this->getWargaFalse();
        //dd($people_false); 
        $people_true = $this->getWargaTrue();
        return view('pengurus.warga.listwarga', compact('people_false', 'people_true'));
    }

    public function getWargaFalse()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?page=1&is_checker=false');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['results'];
       
    }

    public function waiting_approval_warga(Request $request)
    {

        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/warga/?is_checker=false&isreject=false&page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $warga_response = json_decode($response->body(), true);
        //dd($warga_response);
      
        $waiting = $warga_response['results'] ?? [];
        $next_page = $warga_response['next'] ?? null;
        $previous_page = $warga_response['previous'] ?? null;

        $total_pages = (int) ceil($warga_response['count'] / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }
       
        return view('pengurus.warga.waiting_approval', compact('waiting','current','next','prev','next_page','previous_page', 'total_pages'));

    }

    public function approved_warga(Request $request)
    {
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/warga/?is_checker=true&isreject=false&page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $warga_response = json_decode($response->body(), true);
        //dd($warga_response);
      
        $approved = $warga_response['results'] ?? [];
        $next_page = $warga_response['next'] ?? null;
        $previous_page = $warga_response['previous'] ?? null;

        $total_pages = (int) ceil($warga_response['count'] / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }
        //dd($next);
        
        return view('pengurus.warga.approved', compact('approved','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function getWargaTrue()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?page=1&is_checker=true&isreject=false');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['results'];
    }

    public function detail_warga($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/'.$id.'/');
        $warga_response = json_decode($response->body(), true);
        $warga = $warga_response['data'];

        //dd($warga);

        return view('pengurus.warga.detail_warga', compact('warga'));

    }

    public function reject_warga($id)
    {
        $warga_id = $id;
        
        return view('pengurus.warga.reject_form', compact('warga_id'));

    }

    public function post_reject(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'warga_id' => 'required|integer',
            'reason' => 'required|string'
        ]);

        $data = [
            'warga_id' => $request->warga_id,
            'reason' => $request->reason
        ];
        //dd($data);

        try {
            //dd('here');
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->post('https://api.pewaca.id/api/warga/reject/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response->successful()) {
                session()->flash('status', 'success');
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('pengurus.warga.waiting');
            } else {
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('pengurus.warga.waiting');
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Data');
            return redirect()->route('pengurus.warga.waiting');
        }
 
    }

    public function list_biaya(Request $request)
    {
        //dd("here");
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }
        //dd(env('API_URL'));
        $apiUrl = env('API_URL') . '/api/tagihan/?page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $biaya_response = json_decode($response->body(), true);
        
        //dd($biaya_response);
      
        $biaya = $biaya_response['results'] ?? [];
        $next_page = $biaya_response['next'] ?? null;
        $previous_page = $biaya_response['previous'] ?? null;


        if($biaya_response){
            $total_pages = (int) ceil($biaya_response['count'] / 10);
        }
        else {
            $total_pages = (int) 1;
        }
       
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }

        $datadump = [
            'biaya' => $biaya,
            'current' => $current,
            'next' => $next,
            'prev' => $prev,
            'next_page' => $next_page,
            'previous_page' => $previous_page,
            'total_pages' => $total_pages
        ];
        //dd($datadump);
        
        return view('pengurus.tagihan.list_biaya', compact('biaya','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function list_konfirmasi(Request $request)
    {
        
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = 'https://api.pewaca.id/api/tagihan-warga/?page='.$page.'&status=process';

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $konfirmasi_response = json_decode($response->body(), true);
        //dd($konfirmasi_response);
      
        $konfirmasi = $konfirmasi_response['data'] ?? [];
        $next_page = $konfirmasi_response['next'] ?? null;
        $previous_page = $konfirmasi_response['previous'] ?? null;
         
        if(isset($konfirmasi_response['count'])){
            $count = $konfirmasi_response['count'];
        }
        else{
            $count = 10;
        }
        $total_pages = (int) ceil($count / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }
               
        return view('pengurus.tagihan.list_konfirmasi', compact('konfirmasi','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function list_disetujui(Request $request)
    {
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        // $apiUrl = 'https://api.pewaca.id/api/tagihan-warga/self-list/?status=paid&page='.$page;
        $apiUrl = 'https://api.pewaca.id/api/tagihan-warga/?page='.$page.'&status=paid';

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $disetujui_response = json_decode($response->body(), true);
        //dd($disetujui_response);
      
        $disetujui = $disetujui_response['data'] ?? [];
        $next_page = $disetujui_response['next'] ?? null;
        $previous_page = $disetujui_response['previous'] ?? null;
         
        if(isset($disetujui_response['count'])){
            $count = $disetujui_response['count'];
        }
        else{
            $count = 10;
        }
        $total_pages = (int) ceil($count / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }

        return view('pengurus.tagihan.list_disetujui', compact('disetujui','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function list_tunggakan(Request $request)
    {
        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $today = date('Y-m-d');

        //$apiUrl = 'https://api.pewaca.id/api/tagihan-warga/self-list/?status=unpaid&end_due_date=' . $today . '&page=' . $page;
        $apiUrl =   'https://api.pewaca.id/api/tagihan-warga/?page=1&status=unpaid&end_due_date=2025-03-22';
       
        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);
        $tunggakan_response = json_decode($response->body(), true);
        //dd($warga_response);
      
        $tunggakan = $tunggakan_response['data'] ?? [];
        $next_page = $tunggakan_response['next'] ?? null;
        $previous_page = $tunggakan_response['previous'] ?? null;
         
        if(isset($tunggakan_response['count'])){
            $count = $tunggakan_response['count'];
        }
        else{
            $count = 10;
        }
        $total_pages = (int) ceil($count / 10);
       
        $next=null;
        if($next_page != null){
            $p = explode('page=', $next_page);
            $next=$p[1];
        }

        $current = $page;

        $prev=null;
        if($previous_page != null){
            if($page == 2){
                $prev = 1;
            }else{
                $p = explode('page=', $previous_page);
                $prev=$p[1];
            }
            
        }

        return view('pengurus.tagihan.list_tunggakan', compact('tunggakan','current','next','prev','next_page','previous_page', 'total_pages'));
    }

    public function getTagihan()
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan/');
        $tagihan_response = json_decode($response->body(), true);
        return $tagihan_response;
    }

    public function list_confirm()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan-warga/self-list/?status=process');
        $tagihan_response = json_decode($response->body(), true);
        return $tagihan_response;
    }

    public function list_approved()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/tagihan-warga/self-list/?status=paid');
        $tagihan_response = json_decode($response->body(), true);
        return $tagihan_response;
    }

    public function getRole()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/roles/');
        $role_response = json_decode($response->body(), true);
        return  $role_response['results'];
    }

    public function getWarga()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?is_checker=true&isreject=false');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['results'];
    }

    public function addPengurus()
    {
        $roles = $this->getRole();
        $wargas = $this->getWarga();
        //dd($wargas);
        return view('pengurus.role.addrole', compact('roles', 'wargas'));
       
    }

    public function postRole(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'role_id' => 'required|integer',
            'warga_id' => 'required|integer'
        ]);

        $data = [
            'warga' => $request->warga_id,
            'role' => $request->role_id,
        ];

        try {
            //dd('here');
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->post('https://api.pewaca.id/api/residence-commite/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Data pengurus Berhasil Disimpan',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('pengurus.role');
            } else {
                Session::flash('flash-message', [
                    'message' => 'Gagal Menyimpan Data',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('addPengurus');
            }
        
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('addPengurus');
        }

        

    }

}
