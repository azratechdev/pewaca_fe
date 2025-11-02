<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportByCashoutExport implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnFormatting
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
                $item['unit'] ?? '-',
                $item['tanggal'] ?? '-',
                (float)($item['nominal'] ?? 0),
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

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
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
