<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kebundigital.com'],
            [
                'name' => 'Admin Kebun Digital',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '0123456789',
            ]
        );

        // Sample customer
        User::updateOrCreate(
            ['email' => 'customer@kebundigital.com'],
            [
                'name' => 'Ahmad Pelanggan',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '0198765432',
                'address' => 'No 12, Jalan Mawar 3, Taman Bunga Raya, 43000 Kajang, Selangor',
            ]
        );
    }
}
