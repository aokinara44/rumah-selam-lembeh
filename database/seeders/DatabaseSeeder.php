<?php
// Lokasi file: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus komentar pada baris ini untuk memanggil AdminUserSeeder
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Anda bisa tambahkan seeder lain di sini nanti
    }
}