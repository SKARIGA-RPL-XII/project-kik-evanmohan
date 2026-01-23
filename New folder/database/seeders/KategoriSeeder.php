<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Fashion Pria',
                'slug' => Str::slug('Fashion Pria'),
                'deskripsi' => 'Koleksi pakaian dan aksesoris untuk pria.',
                'image' => 'kategori/fashion-pria.jpg',
            ],
            [
                'nama_kategori' => 'Fashion Wanita',
                'slug' => Str::slug('Fashion Wanita'),
                'deskripsi' => 'Koleksi pakaian dan aksesoris untuk wanita.',
                'image' => 'kategori/fashion-wanita.jpg',
            ],
            [
                'nama_kategori' => 'Elektronik',
                'slug' => Str::slug('Elektronik'),
                'deskripsi' => 'Produk elektronik seperti gadget, laptop, dan lainnya.',
                'image' => 'kategori/elektronik.jpg',
            ],
            [
                'nama_kategori' => 'Olahraga',
                'slug' => Str::slug('Olahraga'),
                'deskripsi' => 'Perlengkapan olahraga dan kesehatan.',
                'image' => 'kategori/olahraga.jpg',
            ],
            [
                'nama_kategori' => 'Aksesoris',
                'slug' => Str::slug('Aksesoris'),
                'deskripsi' => 'Barang-barang aksesoris tambahan.',
                'image' => 'kategori/aksesoris.jpg',
            ],
        ];

        // Tambahkan timestamp
        foreach ($kategoris as &$kategori) {
            $kategori['created_at'] = now();
            $kategori['updated_at'] = now();
        }

        DB::table('kategoris')->insert($kategoris);
    }
}
