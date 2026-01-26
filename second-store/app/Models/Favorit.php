<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'variant_id',
        'size_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Favorit.php
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductVariantSize::class, 'size_id');
    }
}
