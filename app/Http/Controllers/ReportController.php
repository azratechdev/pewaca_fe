<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportByTypeExport;
use App\Exports\ReportByCashoutExport;
use App\Exports\ReportTunggakanExport;

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

    public function downloadByType(Request $request)
    {
        $periode = $request->get('periode');
        $type = $request->get('type', 'wajib');
        $residence_id = $this->getResidenceId();

        $apiUrl = "https://admin.pewaca.id/api/report/bytype/?periode={$periode}&residence_id={$residence_id}";
        
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . Session::get('token'),
            'Content-Type' => 'application/json'
        ])->get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $exportData = $data[$type]['data'] ?? [];
            
            $filename = "Laporan_Tipe_{$type}_{$periode}.xlsx";
            return Excel::download(new ReportByTypeExport($exportData, $type, $periode), $filename);
        }

        return back()->with('error', 'Gagal mengunduh data');
    }

    public function downloadByCashout(Request $request)
    {
        $periode = $request->get('periode');
        $type = $request->get('type', 'sudah_bayar');
        $residence_id = $this->getResidenceId();

        $apiUrl = "https://admin.pewaca.id/api/report/cashout/?periode={$periode}&residence_id={$residence_id}";
        
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . Session::get('token'),
            'Content-Type' => 'application/json'
        ])->get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $exportData = $data[$type]['data'] ?? [];
            
            $filename = "Laporan_Pembayaran_{$type}_{$periode}.xlsx";
            return Excel::download(new ReportByCashoutExport($exportData, $type, $periode), $filename);
        }

        return back()->with('error', 'Gagal mengunduh data');
    }

    public function downloadTunggakan(Request $request)
    {
        $periode = $request->get('periode');
        $residence_id = $this->getResidenceId();

        $apiUrl = "https://admin.pewaca.id/api/report/tunggakan/?periode={$periode}&residence_id={$residence_id}";
        
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . Session::get('token'),
            'Content-Type' => 'application/json'
        ])->get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $exportData = $data['units'] ?? [];
            
            $filename = "Laporan_Tunggakan_{$periode}.xlsx";
            return Excel::download(new ReportTunggakanExport($exportData, $periode), $filename);
        }

        return back()->with('error', 'Gagal mengunduh data');
    }

    private function getResidenceId()
    {
        $residenceCommites = Session::get('cred.residence_commites', []);
        $residenceIds = [];
        
        foreach ($residenceCommites as $commite) {
            if (isset($commite['residence']) && is_numeric($commite['residence'])) {
                $residenceIds[] = $commite['residence'];
            }
        }
        
        return $residenceIds[0] ?? 1;
    }
}
