<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus akun lama jika ada
        User::whereIn('email', ['admin@example.com', 'petugas@example.com'])->delete();

        // Buat akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Buat akun Petugas
        User::create([
            'name' => 'Petugas Ruang',
            'email' => 'petugas@example.com',
            'password' => bcrypt('petugas123'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Akun admin dan petugas berhasil dibuat!');
        $this->command->info('');
        $this->command->info('📧 Admin:');
        $this->command->info('   Email: admin@example.com');
        $this->command->info('   Password: admin123');
        $this->command->info('');
        $this->command->info('📧 Petugas:');
        $this->command->info('   Email: petugas@example.com');
        $this->command->info('   Password: petugas123');
    }
}
