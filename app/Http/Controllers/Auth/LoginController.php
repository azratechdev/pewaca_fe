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
        return view('auth.login');
    }
        
    public function postlogin(Request $request)
    {
        
        $capres = $request->input('g-recaptcha-response');
       
        if(isset($capres)){
            $user = User::where('email', $request->email)->where('is_active', 1)->get()->first();
          
            if(empty($user)){
                Session::flash('flash-message', [
                    'message' => 'Unauthorized User',
                    'alert-class' => 'alert-danger',
                ]);
                return redirect()->route('showLoginForm');
            }
            else{
               
                if (Hash::check($request->password, $user->password) && $user->email == $request->email) {
                    //$responses = $this->authenticate($request);
                    $credentials = $request->only('email', 'password');
                    Auth::attempt($credentials);
                    return redirect()->route('dashboard');
                    
                } else {
    
                    if (!Hash::check($request->password, $user->password) || $user->email != $request->email) {
                        Session::flash('flash-message', [
                            'message' => 'Username or Password is incorrect',
                            'alert-class' => 'alert-warning',
                        ]);

                        return redirect()->route('showLoginForm');
                    }
    
                    //$responses = $this->authenticate($request);
    
                }
                
              
              // return redirect()->intended($responses['redirectTo']);
            }
        }
        else{
            Session::flash('flash-message', [
                'message' => 'Invalid Captcha.!',
                'alert-class' => 'alert-warning',
            ]);
            return redirect()->route('showLoginForm');
         
        }
       
    }

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
        $user_id = Auth::user()->id;
        $userToLogout = User::find($user_id);
        Auth::setUser($userToLogout);
        Auth::logout();
        $this->guard();
        Session::flush();
        
        return redirect()->route('showLoginForm');
    }

    protected function guard()
    {
        return Auth::guard();
    }



}
