<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPembayaran extends Model
{
    protected $fillable = [
        'kode_order',
        'order_id',
        'bukti_pembayaran',
        'status',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Order::class);
    }

    public function order()
{
    return $this->belongsTo(Order::class, 'order_id','id');
}

}
