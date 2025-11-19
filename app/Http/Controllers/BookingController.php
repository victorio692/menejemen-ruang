<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\JadwalReguler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        
        // Set minimum date untuk H-2 (besok lusa)
        $minDate = Carbon::now()->addDays(2)->format('Y-m-d');
        $maxDate = Carbon::now()->addDays(30)->format('Y-m-d');
        
        return view('user.booking.create', compact('rooms', 'minDate', 'maxDate'));
    }

    // Simpan booking baru - DENGAN NOTIFIKASI DOUBLE BOOKING
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after:tomorrow',
            'selected_sessions' => 'required|json',
            'purpose' => 'required|string|max:500',
        ]);

        // Parse selected sessions
        $selectedSessions = json_decode($request->selected_sessions);
        
        if (empty($selectedSessions)) {
            return redirect()->back()->with('error', 'Pilih minimal satu sesi!');
        }

        // Validate H-2 rule (minimal besok lusa)
        $bookingDate = Carbon::parse($request->booking_date);
        $minDate = Carbon::now()->addDays(2)->startOfDay();
        
        if ($bookingDate->lt($minDate)) {
            return redirect()->back()->with('error', 'Booking hanya bisa dilakukan minimal H-2 (besok lusa)!');
        }

        // Validate max 30 days in advance
        $maxDate = Carbon::now()->addDays(30)->endOfDay();
        if ($bookingDate->gt($maxDate)) {
            return redirect()->back()->with('error', 'Booking maksimal 30 hari ke depan!');
        }

        // Calculate start and end time from sessions
        $sessionConfig = $this->getSessionTimes();
        $firstSession = min($selectedSessions);
        $lastSession = max($selectedSessions);

        $startTime = $bookingDate->copy()->setTimeFromTimeString($sessionConfig[$firstSession]['start']);
        $endTime = $bookingDate->copy()->setTimeFromTimeString($sessionConfig[$lastSession]['end']);

        // Check if sessions are consecutive
        if (!$this->areSessionsConsecutive($selectedSessions)) {
            return redirect()->back()->with('error', 'Pilih sesi yang berurutan!');
        }

        // ========== TAMBAHKAN TRANSACTION & DOUBLE BOOKING NOTIFICATION ==========
        DB::beginTransaction();

        try {
            // Gunakan LOCK untuk prevent race condition
            $room = Room::where('id', $request->room_id)->lockForUpdate()->first();
            
            if (!$room) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Ruangan tidak ditemukan!');
            }

            // Check for existing bookings - DENGAN INFORMASI DETAIL
            $existingBooking = Booking::where('room_id', $request->room_id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                          ->orWhereBetween('end_time', [$startTime, $endTime])
                          ->orWhere(function($q) use ($startTime, $endTime) {
                              $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                          });
                })
                ->whereIn('status', ['pending', 'disetujui'])
                ->with('user') // Load user data untuk notifikasi
                ->lockForUpdate()
                ->first();

            if ($existingBooking) {
                DB::rollBack();
                
                $userName = $existingBooking->user->name ?? 'User lain';
                $bookingTime = Carbon::parse($existingBooking->start_time)->format('d M Y H:i');
                $purpose = $existingBooking->purpose ?? '-';
                
                $errorMessage = "Ruangan sudah dipesan oleh {$userName} pada {$bookingTime}";
                if ($purpose && $purpose != '-') {
                    $errorMessage .= " untuk: {$purpose}";
                }
                $errorMessage .= ". Silakan pilih waktu lain.";
                
                return redirect()->back()
                    ->with('error', $errorMessage)
                    ->withInput();
            }

            // Check if booking conflicts with regular schedule (jadwal reguler)
            $dayOfWeek = $bookingDate->format('l');
            $dayMapping = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            ];
            $hari = $dayMapping[$dayOfWeek] ?? null;

            // Check for conflicts with regular schedule on weekdays only (Senin-Jumat)
            if (in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) {
                $startTimeStr = $startTime->format('H:i:s');
                $endTimeStr = $endTime->format('H:i:s');
                
                $regularScheduleConflict = JadwalReguler::where('room_id', $request->room_id)
                    ->where('hari', $hari)
                    ->where(function($query) use ($startTimeStr, $endTimeStr) {
                        // Check if regular schedule overlaps with booking time
                        $query->whereRaw("(start_time < ? AND end_time > ?)", [$endTimeStr, $startTimeStr]);
                    })
                    ->lockForUpdate()
                    ->exists();

                if ($regularScheduleConflict) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Ruangan tidak dapat dibooking karena ada jadwal belajar reguler pada waktu tersebut!');
                }
            }

            // Last minute check untuk prevent race condition
            $lastMinuteCheck = Booking::where('room_id', $request->room_id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                          ->orWhereBetween('end_time', [$startTime, $endTime]);
                })
                ->whereIn('status', ['pending', 'disetujui'])
                ->exists();

            if ($lastMinuteCheck) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Maaf, ruangan baru saja dipesan oleh user lain. Silakan refresh dan pilih waktu lain.');
            }

            // Create booking
            Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $request->room_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'purpose' => $request->purpose,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('user.booking.index')->with('success', 'Booking berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Booking Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    // Detail booking
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('room');
        return view('user.booking.show', compact('booking'));
    }

    // Helper method untuk konfigurasi sesi
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

    // Check if sessions are consecutive
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

    // API untuk mendapatkan sesi yang tersedia - DENGAN TRANSACTION
    public function getAvailableSessions(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after:tomorrow',
        ]);

        DB::beginTransaction();

        try {
            $bookingDate = Carbon::parse($request->booking_date);
            $sessionConfig = $this->getSessionTimes();
            $bookedSessions = [];
            $regularScheduleSessions = [];

            // Get existing bookings for the selected date and room - DENGAN LOCK
            $existingBookings = Booking::where('room_id', $request->room_id)
                ->whereDate('start_time', $bookingDate)
                ->whereIn('status', ['pending', 'disetujui'])
                ->lockForUpdate()
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

            // Check for regular schedule conflicts (only on weekdays)
            $dayOfWeek = $bookingDate->format('l');
            $dayMapping = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
            ];
            $hari = $dayMapping[$dayOfWeek] ?? null;

            if (in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])) {
                $regularSchedules = JadwalReguler::where('room_id', $request->room_id)
                    ->where('hari', $hari)
                    ->lockForUpdate()
                    ->get();

                foreach ($regularSchedules as $schedule) {
                    foreach ($sessionConfig as $sessionNumber => $sessionTime) {
                        $sessionStart = $bookingDate->copy()->setTimeFromTimeString($sessionTime['start']);
                        $sessionEnd = $bookingDate->copy()->setTimeFromTimeString($sessionTime['end']);
                        $scheduleStart = Carbon::parse($schedule->start_time);
                        $scheduleEnd = Carbon::parse($schedule->end_time);

                        if ($sessionStart->between($scheduleStart, $scheduleEnd) || 
                            $sessionEnd->between($scheduleStart, $scheduleEnd) ||
                            ($sessionStart->lte($scheduleStart) && $sessionEnd->gte($scheduleEnd))) {
                            $regularScheduleSessions[] = $sessionNumber;
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'available_sessions' => array_diff(range(1, 10), array_merge($bookedSessions, $regularScheduleSessions)),
                'booked_sessions' => $bookedSessions,
                'regular_schedule_sessions' => $regularScheduleSessions
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data sesi',
                'available_sessions' => [],
                'booked_sessions' => [],
                'regular_schedule_sessions' => []
            ], 500);
        }
    }
}