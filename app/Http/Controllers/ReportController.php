<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        
        return view('pengurus.report.index');
    }

    public function detail_report($periode=null)
    {
        $periode = $periode ?? '';
      
        return view('pengurus.report.detail_by_cashout', compact('periode'));
    }

     public function detail_by_type($periode=null)
    {
        $periode = $periode ?? '';
        return view('pengurus.report.detail_by_type', compact('periode'));
    }

    public function detail_tunggakan($periode=null)
    {
        $periode = $periode ?? '';
        return view('pengurus.report.detail_tunggakan', compact('periode'));
    }

   
}
