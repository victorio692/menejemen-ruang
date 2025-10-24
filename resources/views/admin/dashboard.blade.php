@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .bg-purple {
            background: linear-gradient(135deg, #8a5cf5, #6c63ff);
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

        <h3 class="mb-4 fw-bold">Dashboard Admin</h3>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="dashboard-card bg-purple text-center">
                    <h5>Total Users</h5>
                    <h2>{{ $usersCount }}</h2>

                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-blue text-center">
                    <h5>Total Rooms</h5>
                    <h2>{{ $roomsCount }}</h2>

                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-green text-center">
                    <h5>Total Bookings</h5>
                    <h2>{{ $bookingsCount }}</h2>

                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-orange text-center">
                    <h5>Pending Bookings</h5>
                    <h2>{{ $pendingBookings }}</h2>

                </div>
            </div>
        </div>

        <!-- Tombol Manajemen dipindah ke atas tabel -->
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('admin.petugas') }}" class="btn btn-primary">Manajemen User</a>
            <a href="{{ route('admin.rooms') }}" class="btn btn-success">Manajemen Room</a>
            <a href="{{ route('admin.bookings') }}" class="btn btn-warning text-dark">Manajemen Booking</a>
            <a href="{{ route('admin.jadwal_reguler') }}" class="btn btn-info text-white">Manajemen Jadwal Reguler</a>
        </div>

        <div class="card mt-3 shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0">
                <h5 class="fw-bold">Peminjaman Menunggu Verifikasi</h5>
            </div>
            <div class="card-body">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Joined</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </div>
@endsection
