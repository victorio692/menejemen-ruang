<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';       // pastikan nama tabel benar
    protected $primaryKey = 'id_booking';
    public $timestamps = true;           // kalau tidak pakai timestamps set false

    protected $fillable = [
        'id_user',
        'id_room',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }
}
