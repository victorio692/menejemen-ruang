<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalRegularSeeder extends Seeder
{
    public function run(): void
    {
      DB::table('jadwal_regulers')->insert([

            [
                'room_id' => 1,
                'hari' => 'Senin',
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'keterangan' => 'Matematika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => 1,
                'hari' => 'Rabu',
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'keterangan' => 'Bahasa Inggris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
