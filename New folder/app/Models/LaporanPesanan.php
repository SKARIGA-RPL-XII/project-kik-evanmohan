<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPesanan extends Model
{
    protected $table = 'laporan_pesanans';

    protected $fillable = [
        'order_id',
        'kode_order',
        'nama_pembeli',
        'telepon',
        'alamat',
        'total_item',
        'total_bayar',
        'ongkir',
        'ekspedisi',
        'tanggal_validasi'
    ];
}
