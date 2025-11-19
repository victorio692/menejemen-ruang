<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\JadwalReguler;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminController extends Controller
 {
    public function index()
    {
        $usersCount = User::count();
        $roomsCount = Room::count();
        $bookingsCount = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'disetujui')->count();
        $rejectedBookings = Booking::where('status', 'ditolak')->count();
        $jadwalCount = JadwalReguler::count();
        
        // Statistik hari ini
        $today = now()->format('Y-m-d');
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $todayApproved = Booking::where('status', 'disetujui')->whereDate('created_at', $today)->count();
        $todayPending = Booking::where('status', 'pending')->whereDate('created_at', $today)->count();
        $todayRejected = Booking::where('status', 'ditolak')->whereDate('created_at', $today)->count();

        // Data untuk tabel pending bookings
        $pendingBookingList = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'roomsCount',
            'bookingsCount',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings',
            'jadwalCount',
            'todayBookings',
            'todayApproved',
            'todayPending',
            'todayRejected',
            'pendingBookingList'
        )); 
    }

    public function petugas()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.petugas.index', compact('users'));
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
            'role'     => 'required|in:petugas,user',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'User berhasil dibuat.');
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
            'role'     => 'required|in:petugas,user',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'User berhasil diperbarui.');
    }

    public function deletePetugas(User $user)
    {
        $user->delete();
        return redirect()->route('admin.petugas')->with('success', 'User berhasil dihapus.');
    }

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

    public function jadwalReguler()
    {
        $jadwal = JadwalReguler::with('room')
            ->orderBy('hari')
            ->orderBy('start_time')
            ->get();

        return view('admin.jadwal_reguler.index', compact('jadwal'));
    }

    public function createJadwalReguler()
    {
        $rooms = Room::all();

        if ($rooms->isEmpty()) {
            return redirect()->route('admin.jadwal_reguler')
                             ->with('error', 'Belum ada room. Tambahkan room terlebih dahulu.');
        }

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

        return redirect()->route('admin.jadwal_reguler')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
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

        return redirect()->route('admin.jadwal_reguler')
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function deleteJadwalReguler(JadwalReguler $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal_reguler')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }

    // Manajemen Booking
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
        $users = User::where('role', 'user')->get(); // Hanya user biasa
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
            'status'     => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])], // Sesuaikan dengan nilai di database
        ]);

        Booking::create($request->only('user_id', 'room_id', 'start_time', 'end_time', 'purpose', 'status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dibuat.');
    }

    public function editBooking(Booking $booking)
    {
        $users = User::where('role', 'user')->get(); // Hanya user biasa
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
            'status'     => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])], // Sesuaikan dengan nilai di database
        ]);

        $booking->update($request->only('user_id', 'room_id', 'start_time', 'end_time', 'purpose', 'status'));

        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil diperbarui.');
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dihapus.');
    }

    public function reports()
    {
        return redirect()->route('admin.reports.index');
    }

    // Method untuk konfirmasi booking (opsional, bisa digunakan admin juga)
    public function konfirmasiBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'disetujui';
        $booking->approved_at = now();
        $booking->approved_by = Auth::user()->name;
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function tolakBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'ditolak';
        $booking->approved_at = now();
        $booking->approved_by = Auth::user()->name;
        $booking->rejection_reason = $request->input('rejection_reason');
        $booking->save();

        return redirect()->back()->with('error', 'Booking ditolak.');
    }

    // Jadwal Mingguan - Tampilan Terpadu
    public function jadwalMingguan()
    {
        $jadwal = JadwalReguler::with(['room', 'class'])->get();
        $rooms = Room::all();
        
        return view('admin.jadwal_reguler.jadwal_mingguan_per_hari', compact('jadwal', 'rooms'));
    }
}
