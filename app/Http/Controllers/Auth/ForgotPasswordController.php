<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

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
        ])->post('https://api.pewaca.id/api/auth/password-reset/', $data);

        $mail_response = json_decode($response->body(), true);

        //dd($mail_response);

        if(isset($mail_response['success']) && $mail_response['success'] == true) {
           session()->flash('status', 'success');
        } else {
           session()->flash('status', 'error');
        }

        return redirect()->route('showFormReset');

    }

    public function newPassword($uuid, $token)
    {
        if (!$uuid || !$token) {
            abort(404, 'UUID atau Token tidak ditemukan');
        }

        return view('auth.passwords.new');
    }

    public function sendNewpassword(Request $request)
    {   
       
        dd($request->all());
        
    }
    
   
}
