@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-items-center mb-4 gap-3">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-clipboard-check me-2"></i>Detail Booking
        </h3>
        <a href="{{ route('petugas.bookings') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Main Booking Info -->
        <div class="col-lg-8">
            <!-- User & Room Info -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-person-circle me-2"></i>Informasi Pengguna & Ruangan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Nama Pengguna</label>
                            <p class="fw-semibold fs-6 mb-3">
                                <i class="bi bi-person text-primary me-2"></i>
                                {{ $booking->user->name ?? 'Pengguna Tidak Ditemukan' }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Email</label>
                            <p class="fw-semibold fs-6 mb-3">
                                <i class="bi bi-envelope text-info me-2"></i>
                                <a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email ?? '-' }}</a>
                            </p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Ruangan</label>
                            <p class="fw-semibold fs-6 mb-3">
                                <i class="bi bi-building text-success me-2"></i>
                                {{ $booking->room->name ?? 'Ruangan Tidak Ditemukan' }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Kapasitas</label>
                            <p class="fw-semibold fs-6 mb-3">
                                <i class="bi bi-people text-warning me-2"></i>
                                {{ $booking->room->capacity ?? '-' }} orang
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Info -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-calendar-event me-2"></i>Jadwal Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Tanggal & Waktu Mulai</label>
                            <p class="fw-semibold fs-6 mb-2">
                                <i class="bi bi-calendar-event text-success me-2"></i>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}
                            </p>
                            <p class="fw-semibold fs-6">
                                <i class="bi bi-clock text-info me-2"></i>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted small fw-semibold">Tanggal & Waktu Selesai</label>
                            <p class="fw-semibold fs-6 mb-2">
                                <i class="bi bi-calendar-event text-danger me-2"></i>
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y') }}
                            </p>
                            <p class="fw-semibold fs-6">
                                <i class="bi bi-clock text-info me-2"></i>
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-12">
                            <label class="form-label text-muted small fw-semibold">Durasi Peminjaman</label>
                            <p class="fw-semibold fs-6">
                                @php
                                    $duration = \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time);
                                    $hours = floor($duration / 60);
                                    $minutes = $duration % 60;
                                @endphp
                                <i class="bi bi-hourglass-split text-warning me-2"></i>
                                {{ $hours }} jam {{ $minutes }} menit
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose & Status -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-file-text me-2"></i>Tujuan & Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold">Tujuan Peminjaman</label>
                        <p class="fw-semibold fs-6">
                            {{ $booking->purpose ?? '-' }}
                        </p>
                    </div>

                    <hr class="my-3">

                    <div class="mb-0">
                        <label class="form-label text-muted small fw-semibold">Status Booking</label>
                        <p>
                            @if ($booking->status == 'pending')
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                    <i class="bi bi-clock me-1"></i>Pending
                                </span>
                            @elseif($booking->status == 'disetujui')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>Disetujui
                                </span>
                            @elseif($booking->status == 'ditolak')
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if ($booking->rejection_reason)
                <div class="alert alert-danger shadow-sm border-0 rounded-3" role="alert">
                    <div class="d-flex gap-3">
                        <i class="bi bi-exclamation-circle-fill fs-5 flex-shrink-0 mt-1"></i>
                        <div>
                            <h5 class="alert-heading fw-bold mb-2">Alasan Penolakan</h5>
                            <p class="mb-0">{{ $booking->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Timeline -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-calendar me-2"></i>Riwayat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-primary">
                                <i class="bi bi-plus-circle text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="fw-semibold mb-1">Dibuat</p>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}
                                </small>
                            </div>
                        </div>

                        @if ($booking->approved_at)
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $booking->status == 'disetujui' ? 'bg-success' : 'bg-danger' }}">
                                    <i class="bi {{ $booking->status == 'disetujui' ? 'bi-check-circle' : 'bi-x-circle' }} text-white"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="fw-semibold mb-1">
                                        {{ $booking->status == 'disetujui' ? 'Disetujui' : 'Ditolak' }}
                                    </p>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->approved_at)->format('d M Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($booking->approved_by && $booking->approved_at)
                <div class="card shadow-sm border-0 rounded-3 mb-3">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-semibold mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informasi Approval
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Disetujui/Ditolak Oleh</label>
                            <p class="fw-semibold fs-6 mb-0">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                {{ $booking->approved_by }}
                            </p>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted small fw-semibold">Waktu Approval</label>
                            <p class="fw-semibold fs-6 mb-0">
                                <i class="bi bi-calendar-check text-success me-2"></i>
                                {{ \Carbon\Carbon::parse($booking->approved_at)->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($booking->room && $booking->room->description)
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-semibold mb-0">
                            <i class="bi bi-file-text me-2"></i>Deskripsi Ruangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $booking->room->description }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    @if ($booking->status == 'pending')
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="d-grid gap-2 gap-md-3 d-md-flex">
                    <form action="{{ route('petugas.bookings.konfirmasi', $booking->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-check-circle me-2"></i>Setujui Booking
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#rejectModal" style="flex: 1;">
                        <i class="bi bi-x-circle me-2"></i>Tolak Booking
                    </button>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content rounded-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-exclamation-circle me-2"></i>Tolak Booking
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('petugas.bookings.tolak', $booking->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label class="form-label fw-semibold">Alasan Penolakan *</label>
                            <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan booking ini..." required></textarea>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Tolak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .timeline {
        position: relative;
    }

    .timeline-item {
        display: flex;
        gap: 15px;
        position: relative;
        padding-left: 0;
        margin-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 35px;
        width: 2px;
        height: 50px;
        background: #dee2e6;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-marker {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        z-index: 1;
    }

    .timeline-content {
        padding-top: 3px;
    }

    @media (max-width: 992px) {
        .timeline-marker {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .timeline-item::before {
            left: 12px;
        }
    }
</style>
@endsection
