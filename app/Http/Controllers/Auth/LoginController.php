<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.loginwarga');
    }
        
    // public function postlogin()
    // {
    //     return redirect()->route('newtemplate');
       
    // }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           
            $responses = [
                'redirectTo' => 'dashboard',
            ];
           
        } else {
            $responses = [
                'redirectTo' => 'showLoginForm',
            ];
        }
        return $responses;
    }

    public function logout()
    {   
        // $user_id = Auth::user()->id;
        // $userToLogout = User::find($user_id);
        // Auth::setUser($userToLogout);
        // Auth::logout();
        // $this->guard();
        // Session::flush();
        
        return redirect()->route('showLoginForm');
    }

    protected function guard()
    {
        return Auth::guard();
    }



}
