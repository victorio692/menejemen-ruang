<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\JadwalReguler;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $bookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->orderBy('start_time', 'desc')
            ->get();

        $jadwals = JadwalReguler::with('room')
            ->orderBy('kelas', 'asc')
            ->orderBy('hari', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $bookingsCount   = $bookings->count();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('user.dashboard', compact('user', 'bookings', 'jadwals', 'bookingsCount', 'pendingBookings'));
    }
}
