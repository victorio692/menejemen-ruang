<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 Ruang Kelas
        for ($i = 1; $i <= 10; $i++) {
            Room::create([
                'name' => "Ruang Kelas $i",
                'capacity' => 30,
                'description' => "Ruang kelas untuk kegiatan belajar mengajar - Kapasitas 30 siswa",
            ]);
        }

        // 2 Aula
        for ($i = 1; $i <= 2; $i++) {
            Room::create([
                'name' => "Aula $i",
                'capacity' => 100,
                'description' => "Aula untuk acara besar dan pertemuan - Kapasitas 100 orang",
            ]);
        }

        // 1 Ruang Wijaya
        Room::create([
            'name' => 'Ruang Wijaya',
            'capacity' => 50,
            'description' => 'Ruang VIP untuk pertemuan penting - Kapasitas 50 orang',
        ]);

        // 1 Halaman
        Room::create([
            'name' => 'Halaman Sekolah',
            'capacity' => 200,
            'description' => 'Area outdoor untuk kegiatan outdoor - Kapasitas 200 orang',
        ]);

        // 4 Lab
        $labTypes = ['Komputer', 'IPA', 'Bahasa', 'Elektronika'];
        foreach ($labTypes as $index => $type) {
            Room::create([
                'name' => "Lab $type",
                'capacity' => 25,
                'description' => "Laboratorium $type untuk praktikum - Kapasitas 25 siswa",
            ]);
        }
    }
}
