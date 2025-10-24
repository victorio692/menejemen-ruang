@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Daftar Booking Anda</h3>
            <div>
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('user.booking.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Buat Booking Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-semibold">Riwayat Booking Anda</h5>
            </div>
            <div class="card-body p-3">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Ruangan</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->room->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($booking->status == 'pending')
                                        <span class="badge status-badge status-pending">Pending</span>
                                    @elseif($booking->status == 'approved')
                                        <span class="badge status-badge status-approved">Approved</span>
                                    @else
                                        <span class="badge status-badge status-reject">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $booking->purpose ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('user.booking.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Hover effect */
        table.table-hover tbody tr:hover {
            background-color: rgba(108, 117, 125, 0.05);
        }

        /* Card and typography */
        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        /* Status badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 13px;
            color: white;
            font-weight: 500;
        }

        .status-pending {
            background: #ffc107;
            color: #212529;
        }

        .status-approved {
            background: #28a745;
        }

        .status-reject {
            background: #dc3545;
        }

        /* Buttons */
        .btn-success,
        .btn-secondary,
        .btn-primary {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-success:hover,
        .btn-secondary:hover,
        .btn-primary:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
