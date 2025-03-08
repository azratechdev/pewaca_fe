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
        return view('pengurus.tagihan.tagihan_menu', compact('data_tagihan', 'data_confirm', 'data_approved'));
    }

    public function pengurus_role()
    {
        $data_pengurus = $this->getPengurus(); 
        //dd($data_pengurus);
        return view('pengurus.role.listrole', compact('data_pengurus'));
    }

    public function getPengurus()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/residence-commite/');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response;
    }

    public function pengurus_warga()
    {
        $people_false = $this->getWargaFalse(); 
        $people_true = $this->getWargaTrue();
        return view('pengurus.warga.listwarga', compact('people_false', 'people_true'));
    }

    public function getWargaFalse()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/warga/?page=1&is_checker=false&isreject=');
        $warga_response = json_decode($response->body(), true);
        return  $warga_response['results'];
       
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
            'reason' => $request->alasan
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
                return redirect()->route('pengurus');
            } else {
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('pengurus');
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Komentar');
            return redirect()->route('pengurus');
        }
 
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
