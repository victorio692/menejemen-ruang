<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalReguler;
use App\Models\Room;
use App\Models\ClassModel;

class JadwalRegulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Waktu-waktu session dalam sehari (45 menit per session)
        $sessions = [
            ['start' => '07:00', 'end' => '07:45', 'sesi' => '0'],
            ['start' => '07:45', 'end' => '08:30', 'sesi' => '1'],
            ['start' => '08:30', 'end' => '09:15', 'sesi' => '2'],
            ['start' => '09:15', 'end' => '10:00', 'sesi' => '3'],
            ['start' => '10:00', 'end' => '10:45', 'sesi' => '4'],
            ['start' => '10:45', 'end' => '11:30', 'sesi' => '5'],
            ['start' => '12:00', 'end' => '12:45', 'sesi' => '6'],
            ['start' => '12:45', 'end' => '13:30', 'sesi' => '7'],
            ['start' => '13:30', 'end' => '14:15', 'sesi' => '8'],
            ['start' => '14:15', 'end' => '15:00', 'sesi' => '9'],
        ];

        // Hari-hari
        $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Ambil 2 ruangan kelas untuk 2 kelas
        $rooms = Room::where('name', 'like', '%Ruang Kelas%')
                     ->limit(2)
                     ->get();
        
        // Ambil 2 kelas pertama
        $classes = ClassModel::limit(2)->get();

        // Buat jadwal untuk 2 kelas dengan pembagian session yang tidak tabrakan
        // Kelas 1: Ruang Kelas 1, Session 0-4 (pagi sampai sebelum istirahat 2)
        // Kelas 2: Ruang Kelas 2, Session 6-9 (siang sampai sore)
        
        // Jadwal Kelas 1
        $class1 = $classes[0];
        $room1 = $rooms[0];
        foreach ($haris as $hari) {
            foreach ($sessions as $index => $session) {
                if ($index <= 4) { // Session 0-4 untuk kelas 1
                    JadwalReguler::create([
                        'room_id' => $room1->id,
                        'class_id' => $class1->id,
                        'hari' => $hari,
                        'start_time' => $session['start'],
                        'end_time' => $session['end'],
                        'kelas' => $session['sesi'],
                        'keterangan' => "Kelas {$class1->name} - {$room1->name} - Session {$session['sesi']}",
                    ]);
                }
            }
        }

        // Jadwal Kelas 2
        $class2 = $classes[1];
        $room2 = $rooms[1];
        foreach ($haris as $hari) {
            foreach ($sessions as $index => $session) {
                if ($index >= 6) { // Session 6-9 untuk kelas 2
                    JadwalReguler::create([
                        'room_id' => $room2->id,
                        'class_id' => $class2->id,
                        'hari' => $hari,
                        'start_time' => $session['start'],
                        'end_time' => $session['end'],
                        'kelas' => $session['sesi'],
                        'keterangan' => "Kelas {$class2->name} - {$room2->name} - Session {$session['sesi']}",
                    ]);
                }
            }
        }
    }
}
