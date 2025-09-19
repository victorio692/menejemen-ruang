<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\JadwalReguler;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // ============================
    // Dashboard Admin
    // ============================
    public function index()
    {
        $usersCount     = User::count();
        $roomsCount     = Room::count();
        $bookingsCount  = Booking::count();
        $jadwalCount    = JadwalReguler::count();

        return view('admin.dashboard', compact('usersCount', 'roomsCount', 'bookingsCount', 'jadwalCount'));
    }

    // ============================
    // Manajemen Petugas
    // ============================
    public function petugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function createPetugas()
    {
        return view('admin.petugas.create');
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        return redirect()->route('admin.petugas')->with('success', 'Akun Petugas berhasil dibuat.');
    }

    public function editPetugas(User $user)
    {
        return view('admin.petugas.edit', compact('user'));
    }

    public function updatePetugas(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function deletePetugas(User $user)
    {
        $user->delete();
        return redirect()->route('admin.petugas')->with('success', 'Petugas berhasil dihapus.');
    }

    // ============================
    // Manajemen Room
    // ============================
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function createRoom()
    {
        return view('admin.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Room::create($request->only('name', 'capacity', 'description'));

        return redirect()->route('admin.rooms')->with('success', 'Room berhasil dibuat.');
    }

    public function editRoom(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $room->update($request->only('name', 'capacity', 'description'));

        return redirect()->route('admin.rooms')->with('success', 'Room berhasil diperbarui.');
    }

    public function deleteRoom(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms')->with('success', 'Room berhasil dihapus.');
    }

    // ============================
    // Manajemen Jadwal Reguler
    // ============================
    public function jadwalReguler()
    {
        $jadwal = JadwalReguler::with('room')->get(); // ambil semua jadwal dengan room
        return view('admin.jadwal_reguler.index', compact('jadwal'));
    }

    public function createJadwalReguler()
    {
        $rooms = Room::all();
        return view('admin.jadwal_reguler.create', compact('rooms'));
    }

    public function storeJadwalReguler(Request $request)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'hari'        => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'keterangan'  => 'nullable|string'
        ]);

        JadwalReguler::create([
            'room_id'    => $request->room_id,
            'hari'       => $request->hari,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jadwal_reguler')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editJadwalReguler(JadwalReguler $jadwal)
    {
        $rooms = Room::all();
        return view('admin.jadwal_reguler.edit', compact('jadwal', 'rooms'));
    }

    public function updateJadwalReguler(Request $request, JadwalReguler $jadwal)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'hari'        => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'keterangan'  => 'nullable|string'
        ]);

        $jadwal->update([
            'room_id'    => $request->room_id,
            'hari'       => $request->hari,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jadwal_reguler')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function deleteJadwalReguler(JadwalReguler $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal_reguler')->with('success', 'Jadwal berhasil dihapus.');
    }

    // ============================
    // Manajemen Booking
    // ============================
    public function bookings()
    {
        $bookings = Booking::with(['user', 'room'])->orderBy('created_at', 'desc')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        $booking->load(['user', 'room']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function createBooking()
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'purpose'    => 'nullable|string|max:500',
            'status'     => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        Booking::create($request->only('user_id', 'room_id', 'start_time', 'end_time', 'purpose', 'status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dibuat.');
    }

    public function editBooking(Booking $booking)
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.edit', compact('booking', 'users', 'rooms'));
    }

    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'purpose'    => 'nullable|string|max:500',
            'status'     => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $booking->update($request->only('user_id', 'room_id', 'start_time', 'end_time', 'purpose', 'status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil diperbarui.');
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dihapus.');
    }
}
