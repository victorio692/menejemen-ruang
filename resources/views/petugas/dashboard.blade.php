@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <h3 class="mb-4">Dashboard Petugas</h3>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow p-3">
                <h5>Total Rooms</h5>
                <h2>{{ $roomsCount }}</h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow p-3">
                <h5>Total Bookings</h5>
                <h2>{{ $bookingsCount }}</h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow p-3">
                <h5>Pending Bookings</h5>
                <h2>{{ $pendingBookings }}</h2>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('petugas.rooms') }}" class="btn btn-primary">Manajemen Room</a>
        <a href="{{ route('petugas.bookings') }}" class="btn btn-warning me-2">Manajemen Booking</a>
        <a href="{{ route('petugas.jadwal_reguler') }}" class="btn btn-primary">Manajemen Jadwal Reguler</a>

    </div>

    <h4 class="mt-5">Peminjaman Menunggu Verifikasi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pendingBookingList as $booking)
            <tr>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->room->name }}</td>
                <td>{{ $booking->start_time }}</td>
                <td>{{ $booking->end_time }}</td>
                <td>
                    <form action="{{ route('petugas.konfirmasi', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-success btn-sm">Setujui</button>
                    </form>
                    <form action="{{ route('petugas.tolak', $booking->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
