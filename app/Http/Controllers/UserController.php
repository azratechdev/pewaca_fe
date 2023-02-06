<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
   
    public function index()
    {
        $data = User::with('role')->get()->toArray();
        $role = Role::get('name')->toArray();
      
        return view('user.userlist', compact('data','role'));
    }
    
    public function store(Request $request)
    {
        //dd($request->all());
       
        $validator = request()->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        if($validator){
            if(isset($request->id)){
                dd('update data');
               
            }
            else{
                //dd('create data');
                $data = ['name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_active' => $request->isactive];
       
                $role = $request->role;

                dd($data,$role,'save action');
            }
        }
    }

    public function profile()
    {
        $user_id = Auth::user()->id;
        $data = User::with('roles')->where('id', $user_id)->get()->toArray();
        return view('user.profile', compact('data'));

    }
}
