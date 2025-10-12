<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            $api_url = config('services.api_base_url', 'http://127.0.0.1:8000');
            Log::info('API URL: ' . $api_url);
            Log::info('Login data: ', $data);
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($api_url . '/api/auth/login/', $data);

            $data_response = json_decode($response->body(), true);
            
            Log::info('API Response: ', $data_response);
            Log::info('Response Status: ' . $response->status());

            if (isset($data_response['success']) && $data_response['success'] == true) {
                $token = $data_response['data']['token'];
                $refresh_token = $data_response['data']['token_refresh'];

                Log::info('Saving tokens to session');
                Session::put('token', $token); // ✅ access token
                Session::put('refresh_token', $refresh_token); // ✅ refresh token
                Session::put('token_created_at', now()); // ✅ timestamp simpan token

                Log::info('Session after saving token: ', session()->all());
              
                $res = $this->authenticate($data['email']);
                Log::info('Authentication result: ', $res);
                
                // Force session save again after authenticate method
                session()->save();
                
                // Add small delay to ensure session persistence across processes
                usleep(100000); // 100ms delay
                
                Log::info('Session saved after authenticate. All keys: ' . implode(', ', array_keys(Session::all())));
                Log::info('Session cred check after authenticate: ' . (Session::has('cred') ? 'EXISTS' : 'MISSING'));
                Log::info('Before redirect - Final session state: ', Session::all());
                
                $cekstroy = new HomeController();
                $stories = $cekstroy->getStories();

                if(empty($stories)){
                    Session::flash('flash-message', [
                        'message' => $res['message'],
                        'alert-class' => $res['alert'],
                    ]);
                }
                
                Log::info('Before redirect - Session keys: ' . implode(', ', array_keys(Session::all())));
                Log::info('Before redirect - Cred check: ' . (Session::has('cred') ? 'EXISTS' : 'MISSING'));
                Log::info('Redirecting to: ' . $res['redirectTo']);
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
        $api_url = config('services.api_base_url', 'http://127.0.0.1:8000');
        Log::info('Authenticate API URL: ' . $api_url);
        Log::info('Using token: ' . Session::get('token'));
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get($api_url . '/api/auth/profil/');

        $auth_response = json_decode($response->body(), true);
        Log::info('Profile API Response: ', $auth_response);

        if (isset($auth_response['data']['user'])) {
            $credentials = $auth_response['data']['user'];
            $warga_data = $auth_response['data']['warga'] ?? null;
            $residence_data = $auth_response['data']['residence'] ?? null;
            //$unit_data = $auth_response['data']['unit_id'];
           
            Session::put('cred', $credentials);
            Session::put('warga', $warga_data);
            Session::put('residence', $residence_data);
            
            // Force session save to ensure data is persisted
            session()->save();
            
            Log::info('Session data saved:');
            Log::info('Session ID after save: ' . (Session::getId() ?? 'null'));
            Log::info('cred: ', $credentials ?? []);
            Log::info('warga: ', $warga_data ?? []);
            Log::info('residence: ', $residence_data ?? []);
           
           
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
