<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
   
    public function index()
    {
        //dd(Session::get('cred'));
        return view('home.index');
    }

    public function addpost()
    {
        //dd('here');
        return view('home.addpost');
    }
}
