<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Petugas
        User::firstOrCreate(
            ['email' => 'petugas@example.com'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );

        // Users (Peminjam)
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "user$i@example.com"],
                [
                    'name' => "User $i",
                    'password' => Hash::make('user123'),
                    'role' => 'user',
                ]
            );
        }
    }
}
