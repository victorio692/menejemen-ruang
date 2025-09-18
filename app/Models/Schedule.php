<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'id_schedule';
    public $timestamps = true;

    protected $fillable = [
        'id_room',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }
}
