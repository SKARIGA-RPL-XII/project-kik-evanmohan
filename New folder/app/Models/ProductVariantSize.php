<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantSize extends Model
{
    use HasFactory;

    protected $table = 'product_variant_sizes';

    protected $fillable = [
        'variant_id',
        'size',
        'stok',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
