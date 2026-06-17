<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@shoecare.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Buat 1 Akun Kurir
        User::create([
            'name' => 'Kurir Gesit',
            'email' => 'kurir@shoecare.com',
            'password' => Hash::make('kurir123'),
            'role' => 'kurir',
        ]);

        // Buat 1 Akun Pelanggan (Buat testing pesanan)
        User::create([
            'name' => 'Pelanggan Test',
            'email' => 'user@shoecare.com',
            'password' => Hash::make('user123'),
            'role' => 'pelanggan',
        ]);
    }
}