<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\JadwalReguler;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name', 'capacity', 'description'];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_room', 'id_room');
    }

    public function jadwalRegulers()
    {
        return $this->hasMany(JadwalReguler::class, 'id_room', 'id_room');
    }
}
