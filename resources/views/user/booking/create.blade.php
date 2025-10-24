@extends('layouts.app')

@section('title', 'Buat Booking Baru')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Buat Booking Baru</h3>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-3 p-4">
            <form action="{{ route('user.booking.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="room_id" class="form-label fw-semibold">Pilih Ruangan</label>
                    <select name="room_id" id="room_id" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label fw-semibold">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label fw-semibold">Waktu Selesai</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="purpose" class="form-label fw-semibold">Tujuan / Keterangan</label>
                    <textarea name="purpose" id="purpose" class="form-control" rows="3"
                        placeholder="Tuliskan alasan atau keperluan peminjaman ruangan..."></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Buat Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tambahan gaya agar serasi --}}
    <style>
        .card {
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label.form-label {
            color: #495057;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection
