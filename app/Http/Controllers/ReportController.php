<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Dummy data, replace with real data from database or API as needed
        $periode = $request->get('periode', 'mei-2025');
        $totalUangMasuk = 20000000;
        $jumlahWarga = 100;
        $sudahBayar = 80;
        $belumBayar = 20;
        return view('pengurus.report.index', compact('periode', 'totalUangMasuk', 'jumlahWarga', 'sudahBayar', 'belumBayar'));
    }

    public function detail_report(Request $request)
    {
       
        return view('pengurus.report.detail_by_cashout');
    }

     public function detail_by_type(Request $request)
    {
        
        return view('pengurus.report.detail_by_type');
    }

    public function detail_tunggakan(Request $request)
    {
        return view('pengurus.report.detail_tunggakan');
    }

   
}
