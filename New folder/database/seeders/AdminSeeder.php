<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek dulu apakah admin sudah ada
        $exists = DB::table('users')->where('email', 'admin@example.com')->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'username'   => 'Admin',
                'email'      => 'admin@example.com',
                'password'   => Hash::make('1234'), // ✅ jangan lupa pakai Hash
                'no_hp'      => '-',
                'role'       => 'admin',            // pastikan kolom 'role' ada di tabel
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
