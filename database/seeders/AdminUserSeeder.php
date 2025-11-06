<?php
// Lokasi file: database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 1 user admin
        User::create([
            'name' => 'RSDC Admin',
            'email' => 'admin@rumahselamlembeh.com',
            'password' => Hash::make('adminRSDC01'), // Ganti 'password' dengan password aman Anda
        ]);
    }
}