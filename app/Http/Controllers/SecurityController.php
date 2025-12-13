<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SecurityController extends Controller
{
   
    public function list_security(Request $request)
    {

        $filter = $request->input('filter');
        $page = $request->input('page', 1); // Default page = 1 jika tidak ada  

        if (!empty($filter)) {
            $page = 1;
        }

        $apiUrl = env('API_URL') . '/api/security/?page='.$page;

        if (!empty($filter)) {
            $apiUrl .= '&search=' . urlencode($filter);
        }
      
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . Session::get('token'),
        ])->get($apiUrl);

       
        //dd($security_response);
        if (!$response->successful()) {
            Log::error('List Security Failed:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $apiUrl
            ]);
            
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal menghubungi server. Status: ' . $response->status());
            
            return view('pengurus.security.list_security', [
                'data' => [],
                'current' => 1,
                'next' => null,
                'prev' => null,
                'next_page' => null,
                'previous_page' => null,
                'total_pages' => 1
            ]);
        }

        $security_response = json_decode($response->body(), true);
             
        $security = $security_response['results'] ?? [];
        $next_page = $security_response['next'] ?? null;
        $previous_page = $security_response['previous'] ?? null;

        if($security_response){
            $total_pages = (int) ceil($security_response['count'] / 10);
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
       
        return view('pengurus.security.list_security', compact('security','current','next','prev','next_page','previous_page', 'total_pages'));
    }
    
    public function addSec()
    {
        $residence =  Session::get('residence');   
        //dd($residence); 
        return view('pengurus.security.addsecurity', compact('residence'));
    }
   

    public function postSec(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'residence_id' => 'required|integer',
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone_no' => 'required|string'
        ]);

        $data = [
            'residence' => $request->residence_id,
            'fullname' => $request->full_name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];

        //dd($data);

        try {
            
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->post(env('API_URL') . '/api/security/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Data Security Berhasil Disimpan',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('security.listsec');
            } else {
                Session::flash('flash-message', [
                    'message' => 'Gagal Menyimpan Data',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('security.addsec');
            }
        
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('security.addsec');
        }
      

    }

    public function editSec($id)
    {
        //dd($id);
        try {
            
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->get(env('API_URL') . '/api/security/' . $id . '/');
            
            $data_response = json_decode($response->body(), true);

            $data=$data_response ?? [];

        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('security.listsec');
        }

        return view('pengurus.security.editsecurity', compact('data'));
    }

    public function updateSec(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone_no' => 'required|regex:/^\d{8,13}$/'
        ]);

        $id = $request->id;

        $data = [
            'residence' => Session::get('residence')['id'],
            'fullname' => $request->full_name,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ];
        //dd($data);
      
        try {
            
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->put(env('API_URL') . '/api/security/'. $id . '/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Data Security Berhasil Disimpan',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('security.listsec');
            } else {
                Session::flash('flash-message', [
                    'message' => 'Gagal Menyimpan Data',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('security.editsec', ['id' => $id]);
            }
        
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('security.editsec', ['id' => $id]);
        }
    }
        
    public function deleteSec(Request $request)
    {
       
        $id = $request->id;
             
        try {
            
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);
                       
            $response = $http->delete(env('API_URL') . '/api/security/'. $id . '/');

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Data Security Berhasil Dihapus',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('security.listsec');
            } else {
                Session::flash('flash-message', [
                    'message' => 'Gagal Menghapus Data',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('security.listsec');
            }
        
        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Gagal Memproses Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('security.listsec');
        }
      

    }

}
