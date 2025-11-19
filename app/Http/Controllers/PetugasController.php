<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\JadwalReguler;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $approvedBookings = Booking::where('status', 'disetujui')->count();
        $rejectedBookings = Booking::where('status', 'ditolak')->count();
        
        // Statistik hari ini
        $today = now()->format('Y-m-d');
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $todayApproved = Booking::where('status', 'disetujui')->whereDate('created_at', $today)->count();
        $todayPending = Booking::where('status', 'pending')->whereDate('created_at', $today)->count();
        $todayRejected = Booking::where('status', 'ditolak')->whereDate('created_at', $today)->count();

        $pendingBookingList = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('petugas.dashboard', compact(
            'roomsCount',
            'bookingsCount',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings',
            'todayBookings',
            'todayApproved',
            'todayPending',
            'todayRejected',
            'pendingBookingList'
        ));
    }

    // =======================
    // HALAMAN KONFIRMASI (ROUTE BARU)
    // =======================
    public function konfirmasiPage()
    {
        $pendingBookings = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('petugas.konfirmasi', compact('pendingBookings'));
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

    public function showBooking(Booking $booking)
    {
        $booking->load(['user', 'room']);
        return view('petugas.bookings.show', compact('booking'));
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
        $booking->approved_by = Auth::user()->name;
        $booking->approved_at = Carbon::now();
        $booking->save();

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function tolak(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'ditolak';
        $booking->approved_by = Auth::user()->name;
        $booking->approved_at = Carbon::now();
        $booking->rejection_reason = $request->input('rejection_reason');
        $booking->save();

        return redirect()->back()->with('error', 'Booking ditolak.');
    }

    // ============================
    // MANAJEMEN JADWAL REGULER (PETUGAS)
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

    // =======================
    // LAPORAN
    // =======================
    public function reports()
    {
        return redirect()->route('petugas.reports.index');
    }

    // =======================
    // METHOD TAMBAHAN UNTUK SISTEM SESI
    // =======================
    
    /**
     * API untuk mendapatkan sesi yang tersedia
     */
    public function getAvailableSessions(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after:tomorrow',
        ]);

        $bookingDate = Carbon::parse($request->booking_date);
        $sessionConfig = $this->getSessionTimes();
        $bookedSessions = [];

        // Get existing bookings for the selected date and room
        $existingBookings = Booking::where('room_id', $request->room_id)
            ->whereDate('start_time', $bookingDate)
            ->whereIn('status', ['pending', 'disetujui'])
            ->get();

        // Mark booked sessions
        foreach ($existingBookings as $booking) {
            $bookingStart = Carbon::parse($booking->start_time);
            $bookingEnd = Carbon::parse($booking->end_time);
            
            foreach ($sessionConfig as $sessionNumber => $sessionTime) {
                $sessionStart = $bookingDate->copy()->setTimeFromTimeString($sessionTime['start']);
                $sessionEnd = $bookingDate->copy()->setTimeFromTimeString($sessionTime['end']);
                
                if ($sessionStart->between($bookingStart, $bookingEnd) || 
                    $sessionEnd->between($bookingStart, $bookingEnd) ||
                    ($sessionStart->lte($bookingStart) && $sessionEnd->gte($bookingEnd))) {
                    $bookedSessions[] = $sessionNumber;
                }
            }
        }

        return response()->json([
            'available_sessions' => array_diff(range(1, 10), $bookedSessions),
            'booked_sessions' => $bookedSessions
        ]);
    }

    /**
     * Helper method untuk konfigurasi sesi
     */
    private function getSessionTimes()
    {
        return [
            1 => ['start' => '07:00', 'end' => '07:45'],
            2 => ['start' => '07:45', 'end' => '08:30'],
            3 => ['start' => '08:30', 'end' => '09:15'],
            4 => ['start' => '09:15', 'end' => '10:00'],
            5 => ['start' => '10:00', 'end' => '10:45'],
            6 => ['start' => '10:45', 'end' => '11:30'],
            7 => ['start' => '11:30', 'end' => '12:15'],
            8 => ['start' => '12:15', 'end' => '13:00'],
            9 => ['start' => '13:00', 'end' => '13:45'],
            10 => ['start' => '13:45', 'end' => '14:30'],
        ];
    }

    /**
     * Check if sessions are consecutive
     */
    private function areSessionsConsecutive($sessions)
    {
        sort($sessions);
        
        for ($i = 0; $i < count($sessions) - 1; $i++) {
            if ($sessions[$i + 1] - $sessions[$i] !== 1) {
                return false;
            }
        }
        
        return true;
    }
}