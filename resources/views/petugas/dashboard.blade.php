@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            text-align: center;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .bg-blue {
            background: linear-gradient(135deg, #43a4ff, #0575e6);
        }

        .bg-orange {
            background: linear-gradient(135deg, #ff7b5e, #ff4b2b);
        }

        .bg-green {
            background: linear-gradient(135deg, #42e695, #3bb2b8);
        }

        .bg-purple {
            background: linear-gradient(135deg, #8a5cf5, #6c63ff);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .status-approved {
            background: #28a745;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-reject {
            background: #dc3545;
        }
    </style>

    <div class="container-fluid px-4 py-4">

        <h3 class="mb-4 fw-bold">Dashboard Petugas</h3>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="dashboard-card bg-blue">
                    <h5>Total Rooms</h5>
                    <h2>{{ $roomsCount }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-green">
                    <h5>Total Bookings</h5>
                    <h2>{{ $bookingsCount }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-orange">
                    <h5>Pending Bookings</h5>
                    <h2>{{ $pendingBookings }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-purple">
                    <h5>Approved Bookings</h5>
                    <h2>{{ $approvedBookings ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Peminjaman Menunggu Verifikasi -->
        <div class="card mt-4 shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0">
                <h5 class="fw-bold mb-0">Peminjaman Menunggu Verifikasi</h5>
                <small class="text-muted">{{ $pendingBookingList->count() }} booking menunggu persetujuan</small>
            </div>
            <div class="card-body p-0">
                @if($pendingBookingList->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Peminjam</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Durasi</th>
                                    <th>Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingBookingList as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $booking->user->name }}</div>
                                            <small class="text-muted">{{ $booking->user->email }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $booking->room->name }}</span>
                                            <br>
                                            <small class="text-muted">Kapasitas: {{ $booking->room->capacity }} orang</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}</div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} menit
                                            </span>
                                        </td>
                                        <td>
                                            <span title="{{ $booking->purpose }}">
                                                {{ Str::limit($booking->purpose, 40) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <form action="{{ route('petugas.bookings.konfirmasi', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui Booking">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('petugas.bookings.tolak', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak Booking">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted">Tidak ada peminjaman menunggu verifikasi</p>
                        <small class="text-muted">Semua booking telah diproses</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistik dan Aksi Cepat -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-bold mb-0">Statistik Booking Hari Ini</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h3 class="text-primary">{{ $todayBookings ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Booking Hari Ini</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h3 class="text-success">{{ $todayApproved ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Disetujui</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h3 class="text-warning">{{ $todayPending ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Pending</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <h3 class="text-danger">{{ $todayRejected ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Ditolak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        @if (session('success'))
            <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
@endsection