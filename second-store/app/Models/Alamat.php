<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamats';

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'alamat_lengkap',
        'patokan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'is_utama'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
