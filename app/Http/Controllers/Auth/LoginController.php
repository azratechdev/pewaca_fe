<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        
        $capres = $request->input('g-recaptcha-response');
       
        if(isset($capres)){
            $user = User::where('email', $request->email)->where('is_active', 1)->get()->first();
          
            if(empty($user)){
                Session::flash('flash-message', [
                    'message' => 'Unauthorized User',
                    'alert-class' => 'alert-danger',
                ]);
                return redirect()->route('log');
            }
            else{
               
                if (Hash::check($request->password, $user->password) && $user->email == $request->email) {
                    $responses = $this->authenticate($request);
                } else {
    
                    if (!Hash::check($request->password, $user->password) || $user->email != $request->email) {
                        Session::flash('flash-message', [
                            'message' => 'Username or Password is incorrect',
                            'alert-class' => 'alert-warning',
                        ]);
                    }
    
                    $responses = $this->authenticate($request);
    
                }
               return redirect()->route($responses['redirectTo']);
            }
        }
        else{
            Session::flash('flash-message', [
                'message' => 'Invalid Captcha.!',
                'alert-class' => 'alert-warning',
            ]);
            return redirect()->route('log');
         
        }
       
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $responses = [
                'redirectTo' => 'home',
            ];
           
        } else {
            $responses = [
                'redirectTo' => 'log',
            ];
        }
        return $responses;
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        $this->guard();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }



}
