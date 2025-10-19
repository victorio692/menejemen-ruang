<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalReguler extends Model
{
    use HasFactory;

    protected $table = 'jadwal_regulers';
    protected $primaryKey = 'id_reguler';
    protected $fillable = [
        'id_room',
        'kelas',
        'hari',
        'start_time',
        'end_time',
        'keterangan',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room');
    }
}
