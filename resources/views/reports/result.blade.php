@extends('layouts.app')

@section('title', 'Hasil Laporan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">{{ $title }}</h3>
        <div>
            <a href="
            @if(auth()->user()->role === 'admin')
                {{ route('admin.reports.index') }}
            @elseif(auth()->user()->role === 'petugas')
                {{ route('petugas.reports.index') }}
            @else
                {{ route('reports.index') }}
            @endif
            " class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-success">
                <i class="bi bi-file-pdf me-1"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>{{ $stats['total_bookings'] }}</h4>
                    <p>Total Booking</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>{{ $stats['approved_bookings'] }}</h4>
                    <p>Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h4>{{ $stats['pending_bookings'] }}</h4>
                    <p>Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>{{ $stats['rejected_bookings'] }}</h4>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Detail Booking</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Tujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->room->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} menit
                            </td>
                            <td>
                                @if($booking->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $booking->purpose }}</td>
                        </tr>
                        @endforeach
                        @if($bookings->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center py-4">Tidak ada data booking pada periode ini</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart (Optional) -->
    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Grafik Booking</h5>
        </div>
        <div class="card-body">
            <canvas id="bookingChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Jumlah Booking',
                data: @json($chartData['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection