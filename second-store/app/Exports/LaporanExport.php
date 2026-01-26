<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $list;

    public function __construct(Collection $list)
    {
        $this->list = $list;
    }

    public function collection()
    {
        return $this->list->map(function ($row) {
            return [
                'Tanggal'     => $row->created_at->format('d-m-Y'),
                'Kode Order'  => $row->kode_order,
                'Pembeli'     => $row->nama_pembeli,
                'Total Item'  => $row->total_item,
                'Total Bayar' => (int) $row->total_bayar,
                'Ongkir'      => (int) $row->ongkir,
                'Ekspedisi'   => $row->ekspedisi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Order',
            'Pembeli',
            'Total Item',
            'Total Bayar',
            'Ongkir',
            'Ekspedisi',
        ];
    }
}
