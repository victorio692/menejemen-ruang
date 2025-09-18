@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Booking</h3>

    <div class="card p-3">
        <p><strong>User:</strong> {{ $booking->user->name ?? '-' }} ({{ $booking->user->email ?? '-' }})</p>
        <p><strong>Room:</strong> {{ $booking->room->name ?? '-' }}</p>
        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d-m-Y H:i') }} — {{ \Carbon\Carbon::parse($booking->end_time)->format('d-m-Y H:i') }}</p>
        <p><strong>Status:</strong> {{ $booking->status }}</p>
        <p><strong>Purpose:</strong> {{ $booking->purpose }}</p>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
