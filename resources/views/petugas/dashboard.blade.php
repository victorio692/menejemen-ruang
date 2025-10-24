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
            <div class="col-md-4">
                <div class="dashboard-card bg-blue">
                    <h5>Total Rooms</h5>
                    <h2>{{ $roomsCount }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card bg-green">
                    <h5>Total Bookings</h5>
                    <h2>{{ $bookingsCount }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card bg-orange">
                    <h5>Pending Bookings</h5>
                    <h2>{{ $pendingBookings }}</h2>
                </div>
            </div>
        </div>

        <!-- Tombol Manajemen di atas tabel -->
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('petugas.rooms') }}" class="btn btn-primary">Manajemen Room</a>
            <a href="{{ route('petugas.bookings') }}" class="btn btn-warning text-dark">Manajemen Booking</a>
            <a href="{{ route('petugas.jadwal_reguler') }}" class="btn btn-info text-white">Manajemen Jadwal Reguler</a>
        </div>

        <h4 class="mt-5">Peminjaman Menunggu Verifikasi</h4>
        <div class="card shadow-sm border-0 rounded-3 mt-3">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Peminjam</th>
                            <th>Ruangan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingBookingList as $booking)
                            <tr>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->start_time }}</td>
                                <td>{{ $booking->end_time }}</td>
                                <td>
                                    <form action="{{ route('petugas.konfirmasi', $booking->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form action="{{ route('petugas.tolak', $booking->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($pendingBookingList->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada peminjaman menunggu verifikasi</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
