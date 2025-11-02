<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportTunggakanExport implements FromArray, WithHeadings, WithStyles, WithTitle
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
            $rows[] = [
                'unit' => $item['nama_unit'] ?? '-',
                'periode' => is_array($item['periode'] ?? null) ? implode(', ', $item['periode']) : '-',
                'tahun' => $item['tahun'] ?? '-',
                'nominal' => $item['total_nominal'] ?? 0,
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
