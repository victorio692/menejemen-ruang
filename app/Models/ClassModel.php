<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = [
        'name',
        'grade',
        'teacher_name',
        'description',
    ];

    /**
     * Relasi ke JadwalReguler
     * Satu kelas dapat memiliki banyak jadwal regular
     */
    public function jadwalRegulers()
    {
        return $this->hasMany(JadwalReguler::class, 'class_id');
    }
}
