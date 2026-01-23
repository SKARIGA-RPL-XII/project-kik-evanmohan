<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil AdminSeeder
        $this->call(AdminSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(IklanSeeder::class);
        $this->call(ProductVariantSeeder::class);
        $this->call(ProductVariantSizeSeeder::class);
    }
}
