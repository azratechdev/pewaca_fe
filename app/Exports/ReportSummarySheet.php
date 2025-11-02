<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportSummarySheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;
    protected $periode;

    public function __construct($data, $periode)
    {
        $this->data = $data;
        $this->periode = $periode;
    }

    public function array(): array
    {
        $summary = $this->data['summary'] ?? [];
        
        return [
            ['Total Uang Masuk', 'Rp ' . number_format($summary['total_uang_masuk'] ?? 0, 0, ',', '.')],
            ['Jumlah Warga', $summary['jumlah_warga'] ?? 0],
            ['', ''],
            ['Pembayaran', 'Jumlah Unit'],
            ['Sudah Bayar', $summary['sudah_bayar_count'] ?? 0],
            ['Belum Bayar', $summary['belum_bayar_count'] ?? 0],
            ['', ''],
            ['Tipe Pembayaran', 'Nominal (IDR)'],
            ['Wajib', $summary['wajib_total'] ?? 0],
            ['Sukarela', $summary['sukarela_total'] ?? 0],
            ['', ''],
            ['Tunggakan', ''],
            ['Total Unit Tunggakan', $summary['tunggakan_unit'] ?? 0],
            ['Total Nominal Tunggakan', 'Rp ' . number_format($summary['tunggakan_nominal'] ?? 0, 0, ',', '.')],
        ];
    }

    public function headings(): array
    {
        return [
            'Laporan Periode ' . $this->periode,
            ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            'A4' => ['font' => ['bold' => true]],
            'A8' => ['font' => ['bold' => true]],
            'A12' => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}
