<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_produk' => 'Kemeja Flannel Pria',
                'slug' => Str::slug('Kemeja Flannel Pria'),
                'deskripsi' => 'Kemeja flannel kualitas premium dengan bahan lembut dan hangat.',
                'image' => 'products/kemeja-flannel.jpg',
                'kategori_id' => 1,
            ],
            [
                'nama_produk' => 'Blouse Casual Wanita',
                'slug' => Str::slug('Blouse Casual Wanita'),
                'deskripsi' => 'Blouse wanita model casual cocok untuk aktivitas sehari-hari.',
                'image' => 'products/blouse-casual.jpg',
                'kategori_id' => 2,
            ],
            [
                'nama_produk' => 'Headphone Wireless Bluetooth',
                'slug' => Str::slug('Headphone Wireless Bluetooth'),
                'deskripsi' => 'Headphone wireless dengan suara jernih dan baterai tahan lama.',
                'image' => 'products/headphone.jpg',
                'kategori_id' => 3,
            ],
            [
                'nama_produk' => 'Sepatu Olahraga Running',
                'slug' => Str::slug('Sepatu Olahraga Running'),
                'deskripsi' => 'Sepatu ringan dan nyaman untuk kegiatan jogging dan olahraga.',
                'image' => 'products/sepatu-running.jpg',
                'kategori_id' => 4,
            ],
            [
                'nama_produk' => 'Jam Tangan Stylish',
                'slug' => Str::slug('Jam Tangan Stylish'),
                'deskripsi' => 'Jam tangan elegan yang cocok dipakai untuk acara formal maupun santai.',
                'image' => 'products/jam-tangan.jpg',
                'kategori_id' => 5,
            ],
        ];

        // Tambahkan kode_produk dan timestamp
        foreach ($products as &$product) {
            $product['kode_produk'] = 'PRD-' . strtoupper(Str::random(8));
            $product['created_at'] = now();
            $product['updated_at'] = now();
        }

        DB::table('products')->insert($products);
    }
}
