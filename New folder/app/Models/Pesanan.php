<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'alamat_pengiriman',
        'no_hp',
        'subtotal',
        'harga_pengiriman',
        'ekspedisi_id',
        'grand_total',
        'kode_unik',
        'status_bayar',
        'bukti_pembayaran',
        'status_verifikasi',
        'status_pengiriman_manual',
        'status_pengiriman_api',
    ];

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke pengiriman
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pesanan_id');
    }
}
