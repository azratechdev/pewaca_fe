<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function index()
    {
        //dd('here');
        return view('home.index');
    }

    public function addpost()
    {
        //dd('here');
        return view('home.addpost');
    }
}
