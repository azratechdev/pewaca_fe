<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;


class LoginController extends Controller
{
    public function showLoginForm()
    { 
        //dd(session()->all());
        return view('auth.loginwarga');
    }

    public function showActivated()
    {
        return view('auth.activated');
    }
    
    public function postlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' =>  $request->password,
        ];

        //dd($data);
        
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(env('API_URL') . '/api/auth/login/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($data_response['success'] == true) {
                $token = $data_response['data']['token'];
                $refresh_token = $data_response['data']['token_refresh'];

                Session::put('token', $token); // ✅ access token
                Session::put('refresh_token', $refresh_token); // ✅ refresh token
                Session::put('token_created_at', now()); // ✅ timestamp simpan token

                //dd(session()->all());
              
                $res = $this->authenticate($data['email']);
                //dd($res);
                $cekstroy = new HomeController();
                $stories = $cekstroy->getStories();

                if(empty($stories)){
                    Session::flash('flash-message', [
                        'message' => $res['message'],
                        'alert-class' => $res['alert'],
                    ]);
                }
                return redirect()->route($res['redirectTo']);
            } else {
                if($data_response['message'] == 'User is inactive'){
                    session()->flash('status', 'warning');
                    session()->flash('message', 'Gagal Mengirim Data');
                    return redirect()->route('activated');
                }
                else{
                    //dd($data_response['message']);
                    Session::flash('flash-message', [
                        'message' => $data_response['message'],
                        'alert-class' => 'alert-danger',
                    ]);
                    return redirect()->route('showLoginForm');
                }
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
        ])->get(env('API_URL') . '/api/auth/profil/');

        $auth_response = json_decode($response->body(), true);

        \Log::info('=== LOGIN AUTHENTICATE DEBUG ===');
        \Log::info('API Response Full:', ['response' => $auth_response]);
        
        if (isset($auth_response['data']['warga'])) {
            \Log::info('Warga Data from API:', [
                'is_checker' => $auth_response['data']['warga']['is_checker'] ?? 'NOT SET',
                'isreject' => $auth_response['data']['warga']['isreject'] ?? 'NOT SET',
                'full_name' => $auth_response['data']['warga']['full_name'] ?? 'NOT SET'
            ]);
        }
        
        if (isset($auth_response['data']['user'])) {
            $credentials = $auth_response['data']['user'];
            $warga_data = $auth_response['data']['warga'];
            $residence_data = $auth_response['data']['residence'];
            //$unit_data = $auth_response['data']['unit_id'];
           
            Session::put(['cred' => $credentials]);
            Session::put(['warga' => $warga_data]);
            Session::put(['residence' => $residence_data]);
            //Session::put(['unit' => $unit_data]);
            
            \Log::info('Session Warga Stored:', [
                'is_checker' => $warga_data['is_checker'] ?? 'NOT SET',
                'isreject' => $warga_data['isreject'] ?? 'NOT SET'
            ]);
           
           
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
