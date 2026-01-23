<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'nama_metode',
        'tipe',
        'no_rekening',
        'atas_nama',
        'aktif'
    ];
}

