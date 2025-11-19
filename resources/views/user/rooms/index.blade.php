@extends('layouts.app')

@section('title', 'Daftar Ruangan')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Daftar Ruangan Tersedia</h3>
            <div>
                <a href="{{ route('user.booking.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Booking
                </a>
                <a href="{{ route('user.booking.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Buat Booking Baru
                </a>
            </div>
        </div>

        <div class="row">
            @forelse($rooms as $room)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100 
                        {{ $room->is_available ? 'border-success' : 'border-danger' }}">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="fw-semibold {{ $room->is_available ? 'text-primary' : 'text-danger' }}">
                                {{ $room->name }}
                                @if(!$room->is_available)
                                    <small class="text-muted d-block">Sedang Digunakan</small>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">{{ $room->description ?? 'Tidak ada deskripsi' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">
                                    <i class="bi bi-people me-1"></i> Kapasitas: {{ $room->capacity }} orang
                                </span>
                                <span class="badge {{ $room->is_available ? 'bg-success' : 'bg-danger' }}">
                                    @if($room->is_available)
                                        <i class="bi bi-check-circle me-1"></i> Tersedia
                                    @else
                                        <i class="bi bi-x-circle me-1"></i> Tidak Tersedia
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0">
                            @if($room->is_available)
                                <a href="{{ route('user.booking.create') }}?room_id={{ $room->id }}" 
                                   class="btn btn-primary w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Booking Ruangan Ini
                                </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-clock me-1"></i> Sedang Digunakan
                                </button>
                                <small class="text-muted d-block text-center mt-1">
                                    Ruangan sedang dipakai
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-building-x display-4 text-muted"></i>
                            <h5 class="text-muted mt-3">Tidak ada ruangan tersedia</h5>
                            <p class="text-muted">Silakan hubungi administrator untuk menambahkan ruangan.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Info Legend -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Keterangan Status:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="badge bg-success me-2">Tersedia</span>
                                <small class="text-muted">Ruangan bisa dipesan</small>
                            </div>
                            <div class="col-md-3">
                                <span class="badge bg-danger me-2">Tidak Tersedia</span>
                                <small class="text-muted">Sedang digunakan user lain</small>
                            </div>
                            <div class="col-md-3">
                                <span class="badge bg-secondary me-2">Non-Aktif</span>
                                <small class="text-muted">Ruangan tidak bisa dipesan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .border-success {
            border-color: #28a745 !important;
        }
        
        .border-danger {
            border-color: #dc3545 !important;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
        
        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
@endsection