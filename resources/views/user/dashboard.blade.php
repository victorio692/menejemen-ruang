@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <div class="container-fluid px-4 py-4">
        <h3 class="fw-bold mb-4">Halo, {{ $user->name }}</h3>

        {{-- Statistik Utama --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm border-0 rounded-3 p-3">
                    <h5 class="text-muted">Total Booking</h5>
                    <h2 class="fw-bold text-primary">{{ $bookingsCount }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm border-0 rounded-3 p-3">
                    <h5 class="text-muted">Booking Pending</h5>
                    <h2 class="fw-bold text-warning">{{ $pendingBookings }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm border-0 rounded-3 p-3">
                    <h5 class="text-muted">Menu Cepat</h5>
                    <div class="d-grid gap-2 mt-2">
                        <a href="{{ route('user.booking.create') }}" class="btn btn-success btn-sm">Buat Booking</a>
                        <a href="{{ route('user.booking.index') }}" class="btn btn-primary btn-sm">Lihat Booking</a>
                        <a href="{{ route('user.room.index') }}" class="btn btn-info btn-sm">Daftar Ruangan</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Tambahan / Ringkasan --}}
        <div class="card mt-4 shadow-sm border-0 rounded-3">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Ringkasan Aktivitas</h5>
                <p class="text-muted">
                    Anda memiliki <strong>{{ $pendingBookings }}</strong> booking yang masih menunggu verifikasi petugas.
                    Pastikan semua data sudah benar sebelum dikirim.
                </p>
                <a href="{{ route('user.booking.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Booking</a>
            </div>
        </div>
    </div>

    {{-- Style agar selaras --}}
    <style>
        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2.fw-bold {
            font-size: 2.2rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .btn-sm {
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
@endsection
