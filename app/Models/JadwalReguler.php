<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalReguler extends Model
{
    use HasFactory;

    protected $table = 'jadwal_regulers';
    protected $primaryKey = 'id_reguler';
    protected $fillable = ['nama_reguler', 'id_room', 'id_user'];

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
