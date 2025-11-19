<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    // Tampilkan form filter laporan
    public function index()
    {
        $rooms = Room::all();
        return view('reports.index', compact('rooms'));
    }

    // Generate laporan berdasarkan filter
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:weekly,monthly',
            'period' => 'required|date',
            'status' => 'nullable|in:disetujui,pending,ditolak',
        ]);

        $type = $request->type;
        $period = Carbon::parse($request->period);
        $status = $request->status;
        
        // Tentukan range tanggal berdasarkan type
        if ($type === 'weekly') {
            $startDate = $period->copy()->startOfWeek()->format('Y-m-d');
            $endDate = $period->copy()->endOfWeek()->format('Y-m-d');
            $title = "Laporan Booking Mingguan: {$startDate} hingga {$endDate}";
        } else {
            $startDate = $period->copy()->startOfMonth()->format('Y-m-d');
            $endDate = $period->copy()->endOfMonth()->format('Y-m-d');
            $title = "Laporan Booking Bulanan: " . $period->format('F Y');
        }

        // Query data bookings dengan filter status
        // withTrashed() untuk include soft deleted bookings di laporan
        $query = Booking::withTrashed()->with(['user', 'room'])
            ->whereBetween('start_time', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Filter status jika ada
        if ($status) {
            $query->where('status', $status);
            $title .= " - Status: " . ucfirst($status);
        }

        $bookings = $query->orderBy('start_time', 'asc')->get();

        // Statistik
        $stats = [
            'total_bookings' => $bookings->count(),
            'approved_bookings' => $bookings->where('status', 'disetujui')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'rejected_bookings' => $bookings->where('status', 'ditolak')->count(),
            'total_rooms_used' => $bookings->pluck('room_id')->unique()->count(),
            'total_users' => $bookings->pluck('user_id')->unique()->count(),
        ];

        // Check jika export PDF
        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportPDF($bookings, $stats, $title, $startDate, $endDate, $status);
        }

        // Data untuk chart (opsional)
        $chartData = $this->getChartData($bookings, $type, $period);

        return view('reports.result', compact('bookings', 'stats', 'title', 'startDate', 'endDate', 'type', 'period', 'chartData', 'status'));
    }

    // Data untuk chart
    private function getChartData($bookings, $type, $period)
    {
        if ($type === 'weekly') {
            $labels = [];
            $data = [];
            
            $startWeek = $period->copy()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $day = $startWeek->copy()->addDays($i);
                $labels[] = $day->format('D d/m');
                $data[] = $bookings->filter(function($booking) use ($day) {
                    return Carbon::parse($booking->start_time)->isSameDay($day);
                })->count();
            }
        } else {
            $labels = [];
            $data = [];
            $daysInMonth = $period->daysInMonth;
            
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $labels[] = $i;
                $data[] = $bookings->filter(function($booking) use ($period, $i) {
                    return Carbon::parse($booking->start_time)->isSameDay($period->copy()->setDay($i));
                })->count();
            }
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    // Export ke PDF menggunakan DomPDF
    public function exportPDF($bookings, $stats, $title, $startDate, $endDate, $status = null)
    {
        try {
            $filename = 'laporan-booking-' . $startDate . '-' . $endDate;
            if ($status) {
                $filename .= '-' . $status;
            }
            
            $html = view('reports.pdf', compact('bookings', 'stats', 'title', 'startDate', 'endDate', 'status'))->render();
            
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    // Laporan detail per ruangan
    public function roomReport(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'type' => 'required|in:weekly,monthly',
            'period' => 'required|date',
            'status' => 'nullable|in:disetujui,pending,ditolak',
        ]);

        $room = Room::findOrFail($request->room_id);
        $type = $request->type;
        $period = Carbon::parse($request->period);
        $status = $request->status;

        if ($type === 'weekly') {
            $startDate = $period->copy()->startOfWeek()->format('Y-m-d');
            $endDate = $period->copy()->endOfWeek()->format('Y-m-d');
            $title = "Laporan Ruangan {$room->name} - Mingguan: {$startDate} hingga {$endDate}";
        } else {
            $startDate = $period->copy()->startOfMonth()->format('Y-m-d');
            $endDate = $period->copy()->endOfMonth()->format('Y-m-d');
            $title = "Laporan Ruangan {$room->name} - Bulanan: " . $period->format('F Y');
        }

        // Query dengan filter status
        $query = Booking::withTrashed()->with(['user'])
            ->where('room_id', $request->room_id)
            ->whereBetween('start_time', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Filter status jika ada
        if ($status) {
            $query->where('status', $status);
            $title .= " - Status: " . ucfirst($status);
        }

        $bookings = $query->orderBy('start_time', 'asc')->get();

        $stats = [
            'total_bookings' => $bookings->count(),
            'approved_bookings' => $bookings->where('status', 'disetujui')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'rejected_bookings' => $bookings->where('status', 'ditolak')->count(),
            'utilization_rate' => $bookings->where('status', 'disetujui')->count() / max($bookings->count(), 1) * 100,
        ];

        if ($request->has('export') && $request->export === 'pdf') {
            return $this->exportRoomPDF($bookings, $stats, $title, $startDate, $endDate, $room, $status);
        }

        $rooms = Room::all();
        return view('reports.room-result', compact('bookings', 'stats', 'title', 'startDate', 'endDate', 'type', 'period', 'room', 'rooms', 'status'));
    }

    private function exportRoomPDF($bookings, $stats, $title, $startDate, $endDate, $room, $status = null)
    {
        try {
            $filename = 'laporan-ruangan-' . str_replace(' ', '-', $room->name) . '-' . $startDate . '-' . $endDate;
            if ($status) {
                $filename .= '-' . $status;
            }
            
            $html = view('reports.room-pdf', compact('bookings', 'stats', 'title', 'startDate', 'endDate', 'room', 'status'))->render();
            
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    // Method untuk statistik booking real-time
    public function getBookingStats(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $bookings = Booking::whereBetween('start_time', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();

        $stats = [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'disetujui')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'rejected' => $bookings->where('status', 'ditolak')->count(),
        ];

        return response()->json($stats);
    }
}
