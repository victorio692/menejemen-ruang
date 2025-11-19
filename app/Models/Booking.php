<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'user_id',
        'room_id',
        'start_time', 
        'end_time',
        'purpose',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}