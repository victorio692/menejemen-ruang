<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = ['10', '11', '12'];
        $sections = ['A', 'B', 'C', 'D'];
        $teachers = [
            '10-A' => 'Ibu Siti', '10-B' => 'Pak Budi', '10-C' => 'Ibu Rani', '10-D' => 'Pak Ahmad',
            '11-A' => 'Ibu Dewi', '11-B' => 'Pak Hendra', '11-C' => 'Ibu Nur', '11-D' => 'Pak Rinto',
            '12-A' => 'Ibu Eka', '12-B' => 'Pak Bambang', '12-C' => 'Ibu Lisa', '12-D' => 'Pak Doni',
        ];

        foreach ($grades as $grade) {
            foreach ($sections as $section) {
                $className = "$grade-$section";
                ClassModel::create([
                    'name' => $className,
                    'grade' => $grade,
                    'teacher_name' => $teachers[$className] ?? 'Guru ' . $className,
                    'description' => "Kelas $className - Tingkat $grade",
                ]);
            }
        }
    }
}
