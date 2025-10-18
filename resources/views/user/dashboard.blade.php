@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard User</h3>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>Profile</h5>
                <p>Nama: {{ Auth::user()->name }}</p>
                <p>Email: {{ Auth::user()->email }}</p>
                <p>Role: {{ Auth::user()->role }}</p>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>Booking</h5>
                <p>Lihat status booking atau ajukan booking baru.</p>
                <a href="{{ route('user.booking.index') }}" class="btn btn-primary btn-sm">Kelola Booking</a>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>Ruang</h5>
                <p>Lihat daftar ruang yang tersedia.</p>
                <a href="{{ route('user.room.index') }}" class="btn btn-primary btn-sm">Lihat Ruang</a>
            </div>
        </div>
    </div>
</div>
@endsection
