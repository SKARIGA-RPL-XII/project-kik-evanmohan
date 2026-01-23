<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $table = 'ekspedisi';

    protected $fillable = [
        'kode_ekspedisi',
        'nama',
        'deskripsi',
        'ongkir',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($ekspedisi) {
            // Buat kode otomatis berdasarkan ID
            $ekspedisi->kode_ekspedisi = 'EXP' . str_pad($ekspedisi->id, 3, '0', STR_PAD_LEFT);
            $ekspedisi->saveQuietly(); // Gunakan saveQuietly agar tidak trigger event lagi
        });
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'ekspedisi_id');
    }
}
