<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IklanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $iklans = [
            [
                'judul' => 'Promo Kemeja Flannel',
                'gambar' => 'iklan/iklan-kemeja.jpg',
                'produk_id' => 1, // Kemeja Flannel Pria
                'status' => 'ACTIVE',
            ],
            [
                'judul' => 'Diskon Blouse Wanita',
                'gambar' => 'iklan/iklan-blouse.jpg',
                'produk_id' => 2, // Blouse Casual Wanita
                'status' => 'ACTIVE',
            ],
            [
                'judul' => 'Promo Headphone Wireless',
                'gambar' => 'iklan/iklan-headphone.jpg',
                'produk_id' => 3,
                'status' => 'ACTIVE',
            ],
            [
                'judul' => 'Iklan Tanpa Produk',
                'gambar' => 'iklan/generic-banner.jpg',
                'produk_id' => null, // boleh null sesuai migration
                'status' => 'INACTIVE',
            ],
        ];

        // Tambahkan timestamp
        foreach ($iklans as &$iklan) {
            $iklan['created_at'] = now();
            $iklan['updated_at'] = now();
        }

        DB::table('iklans')->insert($iklans);
    }
}
