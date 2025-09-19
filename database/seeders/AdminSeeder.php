<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin utama
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Admin kedua
        User::create([
            'name' => 'Admin Kedua',
            'email' => 'admin2@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
}
