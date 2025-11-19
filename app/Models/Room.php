<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           // Sesuai database
        'capacity',       // Sesuai database  
        'description',    // Sesuai database
    ];

    // Accessor untuk kompatibilitas dengan mobile app
    public function getNamaRuangAttribute()
    {
        return $this->name;
    }

    public function getKapasitasAttribute()
    {
        return $this->capacity;
    }

    public function getFasilitasAttribute()
    {
        return $this->description;
    }

    public function getKodeRuangAttribute()
    {
        return 'ROOM-' . $this->id; // Generate kode ruang
    }

    public function getLokasiAttribute()
    {
        return 'Lantai 1'; // Default value
    }

    public function getStatusAttribute()
    {
        return 'tersedia'; // Default value
    }
}