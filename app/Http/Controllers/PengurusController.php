<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        $data_tagihan = $this->getTagihan();
        $people_false = $this->getWargaFalse(); 

        $people_true = $this->getWargaTrue();
        //dd($people_true);
        return view('pengurus.index', compact('people_false', 'people_true', 'data_tagihan'));
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

        return view('pengurus.detail_warga', compact('warga'));

    }

    public function reject_warga($id)
    {
        $warga_id = $id;
 
        return view('pengurus.reject_form', compact('warga_id'));

    }

    public function post_reject(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'warga_id' => 'required|integer',
            'alasan' => 'required|string'
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

    public function addPengurus()
    {
        return view('pengurus.addrole');
       
    }

}
