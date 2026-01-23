<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'slug',
        'deskripsi',
        'image',
        'kategori_id',
    ];

    // relasi kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // relasi ke varian produk
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // produk muncul di iklan
    public function iklan()
    {
        return $this->hasMany(Iklan::class, 'produk_id');
    }

    public function favorits()
    {
        return $this->hasMany(Favorit::class);
    }

    // generate kode produk & slug otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $lastId = static::max('id') ?? 0;

            // kode otomatis
            $product->kode_produk = 'PRD-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            // slug otomatis
            $product->slug = Str::slug($product->nama_produk);
        });
    }
}
