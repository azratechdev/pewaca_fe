<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role as Roles;
use Spatie\Permission\Models\Permission as Permissions;

class UserController extends Controller
{
   
    public function index()
    {
        $data = User::with('roles')->get()->toArray();
        $role = Roles::all()->pluck('name')->toArray();
        $permission = Permissions::all()->pluck('name')->toArray();
        //dd($permission);
      
        return view('user.userlist', compact('data','role'));
    }
    
    public function store(Request $request)
    {
       
        $validator = request()->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'role' => 'required|string',
            'isactive' => 'required',
            'password' => 'required|string|min:6'
        ]);

        if($validator){
           
            $data = ['name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => $request->isactive];
            
            //dd($data);
            $user = User::create($data);
            $user->assignRole($request->role);

            Session::flash('flash-message', [
                'message' => 'User Created Success.!',
                'alert-class' => 'alert-success',
            ]);
        }
        return redirect()->route('users');
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validator = request()->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string',
            'role' => 'required|string',
            'isactive' => 'required'
        ]);

        if($validator){
           
            $data = ['name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->isactive];
              
            if(isset($request->password)){
                $val = request()->validate([
                   'password' => 'required|string|min:6'
                ]);
                if($val){
                    $password = bcrypt($request->password);
                    $data = array_merge($data, ['password' => $password]);
                }
            }

            $user = User::find($id);
            $user->update($data);
            $user->syncRoles($request->role);
          
            Session::flash('flash-message', [
                'message' => 'User has been updated.!',
                'alert-class' => 'alert-success',
            ]);
    
            return redirect()->route('users');

        }
        else{
            
            Session::flash('flash-message', [
                'message' => 'update failed.!',
                'alert-class' => 'alert-danger',
            ]);
        }
    }

    public function profile()
    {
        $user_id = Auth::user()->id;
        $data = User::with('roles')->where('id', $user_id)->get()->toArray();
        return view('user.profile', compact('data'));

    }

    public function getUser(Request $request)
    {
        $validator = request()->validate([
            '_token' => 'required|string|max:100'
        ]);

        if($validator){
            $id = $request->id;
            $data = User::with('roles')->find($id);
            return response()->json(['data' => $data]);
        }    
    }

    public function destroy($id)
    {
       
        $user = User::find($id);
        $user->delete();

        Session::flash('flash-message', [
            'message' => 'User has been deleted.!',
            'alert-class' => 'alert-success',
        ]);

        return redirect()->route('users');
    }
}
