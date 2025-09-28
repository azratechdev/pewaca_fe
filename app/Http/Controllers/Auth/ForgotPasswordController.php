<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
   
    public function showFormReset()
    {
        return view('auth.passwords.reset');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $data = ['email' => $request->email];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('http://43.156.75.206/api/auth/password-reset/', $data);

        $mail_response = json_decode($response->body(), true);

        if(isset($mail_response['success']) && $mail_response['success'] == true) {
           session()->flash('status', 'success');
        } else {
           session()->flash('status', 'error');
        }

        return redirect()->route('showFormReset');

    }

    public function newPassword($uuid = null, $token = null)
    {
        if (!$uuid || !$token) {
            abort(404, 'UUID atau token tidak ditemukan');
        }

        return view('auth.passwords.new');
    }

    public function sendNewpassword(Request $request)
    {   
        $request->validate([
            'password' => 'required|string',
            'confirm_password' => 'required|string'
        ]);

        //dd($request->all());
        
        if($request->password != $request->confirm_password){
            session()->flash('status', 'warning');
            session()->flash('message', 'Pastikan konfirmasi kata sandi benar.');
            return redirect()->route('newPassword', ['uuid' => $request->code, 'token' => $request->token]);
        }

        $data = ['new_password' => $request->password];
       // dd($data);
        try{
            $http = Http::withHeaders([
                'Accept' => 'application/json',
            ]);
        
            $response = $http->post('http://43.156.75.206/api/auth/reset/'.$request->code."/".$request->token."/", $data);
            $reset_response = json_decode($response->body(), true);
            //dd($reset_response);
            if ($response->successful()) {
                //dd('HERE =', $reset_response);
                session()->flash('status', 'success');
                session()->flash('message', $reset_response['data']['message']);
                return redirect()->route('newPassword', ['uuid' => $request->code, 'token' => $request->token]);
            }
            else{
                session()->flash('status', 'warning');
                session()->flash('message', $reset_response['new_password'][0]);
                return redirect()->route('newPassword', ['uuid' => $request->code, 'token' => $request->token]);
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengatur ulang kata sandi');
            return redirect()->route('newPassword', ['uuid' => $request->code, 'token' => $request->token]);
        }
    }
}
