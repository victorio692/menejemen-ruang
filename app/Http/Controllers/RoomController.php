<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class RoomController extends Controller
{
    // Daftar semua room dengan status ketersediaan
    public function index()
    {
        $rooms = Room::all();
        $now = Carbon::now();
        
        // Cek ketersediaan setiap ruangan
        foreach ($rooms as $room) {
            $room->is_available = $this->checkRoomAvailability($room->id, $now);
        }
        
        return view('user.rooms.index', compact('rooms'));
    }

    // Fungsi cek ketersediaan ruangan
    private function checkRoomAvailability($roomId, $currentTime)
    {
        // Cek apakah ada booking aktif untuk ruangan ini
        $activeBooking = Booking::where('room_id', $roomId)
            ->where('status', 'approved') // Hanya booking yang approved
            ->where(function($query) use ($currentTime) {
                $query->where('start_time', '<=', $currentTime)
                      ->where('end_time', '>=', $currentTime);
            })
            ->exists();
            
        return !$activeBooking; // Jika tidak ada booking aktif, maka tersedia
    }
}