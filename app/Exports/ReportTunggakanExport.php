<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportTunggakanExport implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnFormatting
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
        $rows = [];
        foreach ($this->data as $item) {
            $nominal = $item['total_nominal'] ?? 0;
            
            // Ensure nominal is numeric
            if (is_numeric($nominal)) {
                $nominal = floatval($nominal);
            } else {
                $nominal = 0;
            }
            
            $rows[] = [
                $item['nama_unit'] ?? '-',
                is_array($item['periode'] ?? null) ? implode(', ', $item['periode']) : '-',
                $item['tahun'] ?? '-',
                $nominal,
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nama Unit',
            'Periode Tunggakan',
            'Tahun',
            'Total Nominal (IDR)',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Tunggakan';
    }
}
