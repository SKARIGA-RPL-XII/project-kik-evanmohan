<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'telepon',
        'alamat',     // ✔ alamat string
        'total_barang',
        'total_harga',
        'ongkir',
        'total_bayar',
        'metode_pengiriman',
        'metode_pembayaran',
        'kode_order',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function buktiPembayaran()
    {
        return $this->hasOne(BuktiPembayaran::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }
}
