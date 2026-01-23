<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $table = 'iklans';

    protected $fillable = [
        'judul',
        'gambar',
        'produk_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
