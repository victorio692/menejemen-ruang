<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class PetugasController extends Controller
{
    // Dashboard petugas
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])->latest()->paginate(10);
        return view('petugas.dashboard', compact('bookings'));
    }

    // Konfirmasi booking
    public function konfirmasi($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'disetujui';
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    // Tolak booking
    public function tolak($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'ditolak';
        $booking->save();

        return redirect()->back()->with('error', 'Booking ditolak');
    }
}
