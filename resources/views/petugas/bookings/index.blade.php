@extends('layouts.app')

@section('title', 'Manajemen Booking - Petugas')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Booking</h3>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Nama Room</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ $booking->room->name ?? '-' }}</td>
                    <td>{{ $booking->tanggal }}</td>
                    <td>{{ $booking->waktu_mulai }} - {{ $booking->waktu_selesai }}</td>
                    <td>
                        @if($booking->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->status == 'pending')
                            <form action="{{ route('petugas.bookings.konfirmasi', $booking->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Setujui</button>
                            </form>

                            <form action="{{ route('petugas.bookings.tolak', $booking->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-sm">Tolak</button>
                            </form>
                        @endif

                        <form action="{{ route('petugas.bookings.delete', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data booking</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
