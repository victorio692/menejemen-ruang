@extends('layouts.app')

@section('title', 'Manajemen Booking - Petugas')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-calendar-check me-2"></i>Manajemen Booking
        </h3>
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-house me-1"></i>Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-semibold mb-0 text-primary">
                <i class="bi bi-list-check me-2"></i>Daftar Booking
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>User</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td class="px-4 fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person text-muted me-2"></i>
                                        {{ $booking->user->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-building text-muted me-1"></i>
                                    {{ $booking->room->name ?? 'Ruangan Tidak Ditemukan' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if ($booking->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($booking->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($booking->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <a href="{{ route('petugas.bookings.show', $booking->id) }}" class="btn btn-info btn-sm rounded-pill px-3" title="Lihat Detail">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                        @if ($booking->status == 'pending')
                                            <form action="{{ route('petugas.bookings.konfirmasi', $booking->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3"
                                                    onclick="return confirm('Setujui booking ini?')">
                                                    <i class="bi bi-check-circle me-1"></i>Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('petugas.bookings.tolak', $booking->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3"
                                                    onclick="return confirm('Tolak booking ini?')">
                                                    <i class="bi bi-x-circle me-1"></i>Tolak
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('petugas.bookings.delete', $booking->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3"></i><br>
                                    <small>Belum ada data booking</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
