<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.loginwarga');
    }

    public function showActivated()
    {
        return view('auth.activated');
    }

    public function postActivated(Request $request)
    {
        Session::flash('flash-message', [
            'message' => 'Aktifasi sukses',
            'alert-class' => 'alert-success',
        ]);
        return redirect()->route('home');
    
    }
        
    public function postlogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
    
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://admin.pewaca.id/api/auth/login/', [
                'email' => $email,
                'password' => $password,
            ]);

            $data_response = json_decode($response->body(), true);

            if ($data_response['success'] == true) {
                $token = $data_response['data']['token'];
                Session::put('token', $token); // Simpan token ke dalam session
                $res = $this->authenticate($email);

                Session::flash('flash-message', [
                    'message' => $res['message'],
                    'alert-class' => $res['alert'],
                ]);
                return redirect()->route($res['redirectTo']);
            } else {
                Session::flash('flash-message', [
                    'message' => $data_response['message'],
                    'alert-class' => 'alert-danger',
                ]);
                return redirect()->route('showLoginForm');
            }

        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Unauthorized',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('showLoginForm');
        }
    }

    public function authenticate($email)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://admin.pewaca.id/api/auth/profil/');

        $auth_response = json_decode($response->body(), true);
        
        if (isset($auth_response['data']['user'])) {
            $credentials = $auth_response['data']['user'];
           
            Session::put(['cred' => $credentials]);
           
            if ($credentials['email'] == $email && $credentials['is_active'] == true) {
               
                $responses = [
                    'redirectTo' => 'home',
                    'alert' =>  'alert-success',
                    'message' => 'Welcome '.$credentials['username']
                ];
               
            } 
            else {
                $responses = [
                    'redirectTo' => 'activated', # selanjutnya di direct ke halaman activasi
                    'alert' =>  'alert-danger',
                    'message' => 'Account not active'
                ];
            }
           
        } 
        else {
            $responses = [
                'redirectTo' => 'showLoginForm',
                'alert' =>  'alert-danger',
                'message' => 'No credentials found'
            ];
        }
        
        return $responses;
    }

    public function logout()
    {   
        
        $this->guard();
        Session::flush();
        Session::flash('flash-message', [
            'message' => 'Logout Success',
            'alert-class' => 'alert-success',
        ]);
        
        return redirect()->route('showLoginForm');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
