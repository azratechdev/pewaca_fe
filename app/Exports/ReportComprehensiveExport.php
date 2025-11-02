<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportComprehensiveExport implements WithMultipleSheets
{
    protected $allData;
    protected $periode;

    public function __construct($allData, $periode)
    {
        $this->allData = $allData;
        $this->periode = $periode;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Ringkasan
        $sheets[] = new ReportSummarySheet($this->allData, $this->periode);

        // Sheet 2: Sudah Bayar
        if (!empty($this->allData['sudah_bayar'])) {
            $sheets[] = new ReportByCashoutExport($this->allData['sudah_bayar'], 'sudah_bayar', $this->periode);
        }

        // Sheet 3: Belum Bayar
        if (!empty($this->allData['belum_bayar'])) {
            $sheets[] = new ReportByCashoutExport($this->allData['belum_bayar'], 'belum_bayar', $this->periode);
        }

        // Sheet 4: Wajib
        if (!empty($this->allData['wajib'])) {
            $sheets[] = new ReportByTypeExport($this->allData['wajib'], 'wajib', $this->periode);
        }

        // Sheet 5: Sukarela
        if (!empty($this->allData['sukarela'])) {
            $sheets[] = new ReportByTypeExport($this->allData['sukarela'], 'sukarela', $this->periode);
        }

        // Sheet 6: Tunggakan
        if (!empty($this->allData['tunggakan'])) {
            $sheets[] = new ReportTunggakanExport($this->allData['tunggakan'], $this->periode);
        }

        return $sheets;
    }
}
