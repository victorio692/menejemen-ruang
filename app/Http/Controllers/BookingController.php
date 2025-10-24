<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Tampilkan daftar booking user
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->orderBy('start_time', 'desc')
            ->get();
        return view('user.booking.index', compact('bookings'));
    }

    // Form buat booking baru
    public function create()
    {
        $rooms = Room::all();
        return view('user.booking.create', compact('rooms'));
    }

    // Simpan booking baru
    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'purpose'    => 'nullable|string|max:500',
        ]);

        Booking::create([
            'user_id'    => Auth::id(),
            'room_id'    => $request->room_id,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'purpose'    => $request->purpose,
            'status'     => 'pending',
        ]);

        return redirect()->route('user.booking.index')->with('success', 'Booking berhasil dibuat.');
    }

    // Detail booking
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking); // pastikan hanya pemilik bisa melihat
        $booking->load('room');
        return view('user.booking.show', compact('booking'));
    }
}
