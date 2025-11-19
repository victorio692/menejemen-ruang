<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalReguler extends Model
{
    use HasFactory;

    protected $table = 'jadwal_regulers';
    protected $fillable = [
        'room_id',
        'class_id',
        'kelas',
        'hari',
        'start_time',
        'end_time',
        'keterangan',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
