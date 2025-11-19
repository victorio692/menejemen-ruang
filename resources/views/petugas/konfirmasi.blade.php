@extends('layouts.petugas')

@section('title', 'Konfirmasi Booking')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Konfirmasi Booking</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Booking Menunggu Konfirmasi</h6>
        </div>
        <div class="card-body">
            @if($pendingBookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Ruangan</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Tujuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingBookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</td>
                                <td>{{ $booking->purpose }}</td>
                                <td>
                                    <form action="{{ route('petugas.bookings.konfirmasi', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                    </form>
                                    <form action="{{ route('petugas.bookings.tolak', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">Tidak ada booking yang menunggu konfirmasi.</p>
            @endif
        </div>
    </div>
</div>
@endsection