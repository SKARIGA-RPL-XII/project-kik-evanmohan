<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\ProductVariantSize;

class ProductVariantSizeSeeder extends Seeder
{
    public function run(): void
    {
        // daftar size default
        $sizes = [
            ['size' => 'S',  'stok' => 5],
            ['size' => 'M',  'stok' => 7],
            ['size' => 'L',  'stok' => 6],
            ['size' => 'XL', 'stok' => 4],
        ];

        $variants = ProductVariant::all();

        foreach ($variants as $variant) {
            foreach ($sizes as $s) {
                ProductVariantSize::create([
                    'variant_id' => $variant->id,
                    'size'       => $s['size'],
                    'stok'       => $s['stok'],
                ]);
            }
        }
    }
}
