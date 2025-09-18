<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // ============================
    // Dashboard Admin
    // ============================
    public function index()
    {
        $usersCount    = User::count();
        $roomsCount    = Room::count();
        $bookingsCount = Booking::count();

        return view('admin.dashboard', compact('usersCount', 'roomsCount', 'bookingsCount'));
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

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

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
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
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
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
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
// Manajemen Jadwal Ruang
// ============================
public function schedules()
{
    $schedules = \App\Models\Schedule::with('room')->get();
    return view('admin.schedules.index', compact('schedules'));
}

public function createSchedule()
{
    $rooms = Room::all();
    return view('admin.schedules.create', compact('rooms'));
}

public function storeSchedule(Request $request)
{
    $request->validate([
        'id_room' => 'required|exists:rooms,id_room',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        'keterangan' => 'nullable|string'
    ]);

    \App\Models\Schedule::create($request->all());

    return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil ditambahkan.');
}

public function editSchedule(\App\Models\Schedule $schedule)
{
    $rooms = Room::all();
    return view('admin.schedules.edit', compact('schedule', 'rooms'));
}

public function updateSchedule(Request $request, \App\Models\Schedule $schedule)
{
    $request->validate([
        'id_room' => 'required|exists:rooms,id_room',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        'keterangan' => 'nullable|string'
    ]);

    $schedule->update($request->all());

    return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil diperbarui.');
}

public function deleteSchedule(\App\Models\Schedule $schedule)
{
    $schedule->delete();
    return redirect()->route('admin.schedules')->with('success', 'Jadwal berhasil dihapus.');
}

    // ============================
    // Manajemen Booking
    // ============================
    // List semua booking
    public function bookings()
    {
        $bookings = Booking::with(['user', 'room'])->orderBy('created_at', 'desc')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // Detail booking
    public function showBooking(Booking $booking)
    {
        $booking->load(['user','room']);
        return view('admin.bookings.show', compact('booking'));
    }

    // Form create booking
    public function createBooking()
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.create', compact('users','rooms'));
    }

    // Store booking
    public function storeBooking(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'purpose'    => 'nullable|string|max:500',
            'status'     => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        Booking::create($request->only('user_id','room_id','start_time','end_time','purpose','status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dibuat.');
    }

    // Form edit booking
    public function editBooking(Booking $booking)
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.edit', compact('booking','users','rooms'));
    }

    // Update booking
    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'purpose'    => 'nullable|string|max:500',
            'status'     => ['required', Rule::in(['pending','approved','rejected'])],
        ]);

        $booking->update($request->only('user_id','room_id','start_time','end_time','purpose','status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil diperbarui.');
    }

    // Hapus booking
    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dihapus.');
    }
}
