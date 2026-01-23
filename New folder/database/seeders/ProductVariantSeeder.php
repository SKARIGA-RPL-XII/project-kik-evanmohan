<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        // daftar warna default
        $warnaList = [
            [
                'warna' => 'Hitam',
                'harga' => 120000,
                'stok'  => 10,
                'image' => 'variants/hitam.jpg',
            ],
            [
                'warna' => 'Putih',
                'harga' => 125000,
                'stok'  => 8,
                'image' => 'variants/putih.jpg',
            ],
            [
                'warna' => 'Merah',
                'harga' => 130000,
                'stok'  => 5,
                'image' => 'variants/merah.jpg',
            ],
        ];

        $products = Product::all();

        foreach ($products as $product) {
            foreach ($warnaList as $w) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'warna'      => $w['warna'],
                    'harga'      => $w['harga'],
                    'stok'       => $w['stok'],
                    'image'      => $w['image'],
                ]);
            }
        }
    }
}
