<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\JadwalReguler;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // =======================
    // DASHBOARD PETUGAS
    // =======================
    public function index()
    {
        $roomsCount = Room::count();
        $bookingsCount = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingBookingList = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.dashboard', compact(
            'roomsCount',
            'bookingsCount',
            'pendingBookings',
            'pendingBookingList'
        ));
    }

    // =======================
    // MANAJEMEN ROOM
    // =======================
    public function rooms()
    {
        $rooms = Room::all();
        return view('petugas.rooms.index', compact('rooms'));
    }

    public function createRoom()
    {
        return view('petugas.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'description' => $request->description,
        ]);

        return redirect()->route('petugas.rooms')->with('success', 'Room berhasil ditambahkan.');
    }

    public function deleteRoom(Room $room)
    {
        $room->delete();
        return redirect()->route('petugas.rooms')->with('success', 'Room berhasil dihapus.');
    }

    // =======================
    // MANAJEMEN BOOKING
    // =======================
    public function bookings()
    {
        $bookings = Booking::with(['user', 'room'])->orderBy('created_at', 'desc')->get();
        return view('petugas.bookings.index', compact('bookings'));
    }

    public function createBooking()
    {
        $rooms = Room::all();
        return view('petugas.bookings.create', compact('rooms'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('petugas.bookings')->with('success', 'Booking berhasil dibuat.');
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('petugas.bookings')->with('success', 'Booking berhasil dihapus.');
    }

    // =======================
    // KONFIRMASI & PENOLAKAN BOOKING
    // =======================
    public function konfirmasi($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'disetujui';
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function tolak($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'ditolak';
        $booking->save();

        return redirect()->back()->with('error', 'Booking ditolak.');
    }

    // ============================
// Manajemen Jadwal Reguler (Petugas)
// ============================
public function jadwalReguler()
{

    $jadwal = JadwalReguler::with('room')->orderBy('hari')->orderBy('start_time')->get();
    return view('petugas.jadwal_reguler.index', compact('jadwal'));
}

public function createJadwalReguler()
{
    $rooms = Room::all();
    return view('petugas.jadwal_reguler.create', compact('rooms'));
}

public function storeJadwalReguler(Request $request)
{
    $request->validate([
        'room_id'    => 'required|exists:rooms,id',
        'hari'       => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'end_time'   => 'required|date_format:H:i|after:start_time',
        'keterangan' => 'nullable|string',
    ]);

    JadwalReguler::create([
        'room_id'    => $request->room_id,
        'hari'       => $request->hari,
        'start_time' => $request->start_time,
        'end_time'   => $request->end_time,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('petugas.jadwal_reguler')->with('success', 'Jadwal berhasil dibuat.');
}

public function editJadwalReguler(JadwalReguler $jadwal)
{
    $rooms = Room::all();
    return view('petugas.jadwal_reguler.edit', compact('jadwal', 'rooms'));
}

public function updateJadwalReguler(Request $request, JadwalReguler $jadwal)
{
    $request->validate([
        'room_id'    => 'required|exists:rooms,id',
        'hari'       => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'end_time'   => 'required|date_format:H:i|after:start_time',
        'keterangan' => 'nullable|string',
    ]);

    $jadwal->update($request->only('room_id','hari','start_time','end_time','keterangan'));

    return redirect()->route('petugas.jadwal_reguler')->with('success', 'Jadwal berhasil diperbarui.');
}

public function deleteJadwalReguler(JadwalReguler $jadwal)
{
    $jadwal->delete();
    return redirect()->route('petugas.jadwal_reguler')->with('success', 'Jadwal berhasil dihapus.');
}
}
