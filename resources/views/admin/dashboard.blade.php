@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow p-3">
                <h5>Total Users</h5>
                <h2>{{ $usersCount }}</h2>
            </div>
        </div>
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
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.petugas') }}" class="btn btn-primary me-2">Manajemen Petugas</a>
        <a href="{{ route('admin.rooms') }}" class="btn btn-success me-2">Manajemen Room</a>
        <a href="{{ route('admin.bookings') }}" class="btn btn-warning">Manajemen Booking</a>
        <a href="{{ route('admin.jadwal_reguler') }}" class="btn btn-info">Manajemen Jadwal Reguler</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
@endsection
