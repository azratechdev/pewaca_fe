<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportByCashoutExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;
    protected $type;
    protected $periode;

    public function __construct($data, $type, $periode)
    {
        $this->data = $data;
        $this->type = $type;
        $this->periode = $periode;
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->data as $item) {
            $rows[] = [
                'unit' => $item['unit'] ?? '-',
                'tanggal' => $item['tanggal'] ?? '-',
                'nominal' => $item['nominal'] ?? 0,
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nama Unit',
            'Tanggal Pembayaran',
            'Nominal (IDR)',
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
        return ucfirst(str_replace('_', ' ', $this->type));
    }
}
