@extends('layouts.app')

@section('title', isset($booking) ? 'Edit Booking' : 'Buat Booking')

@section('content')
<div class="container">
    <h3 class="mb-4">{{ isset($booking) ? 'Edit Booking' : 'Buat Booking' }}</h3>

    @if($errors->any())
      <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ isset($booking) ? route('admin.bookings.update', $booking->id) : route('admin.bookings.store') }}" method="POST">
        @csrf
        @if(isset($booking)) @method('PUT') @endif

        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- pilih user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ (old('user_id', $booking->user_id ?? '') == $u->id) ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room</label>
            <select name="room_id" class="form-control" required>
                <option value="">-- pilih room --</option>
                @foreach($rooms as $r)
                    <option value="{{ $r->id }}" {{ (old('room_id', $booking->room_id ?? '') == $r->id) ? 'selected' : '' }}>{{ $r->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time', isset($booking) ? \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time', isset($booking) ? \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') : '') }}" required>
        </div>

        <div class="mb-3">
            <label>Purpose / Keterangan</label>
            <textarea name="purpose" class="form-control">{{ old('purpose', $booking->purpose ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @php $st = old('status', $booking->status ?? 'pending'); @endphp
                <option value="pending" {{ $st=='pending' ? 'selected':'' }}>pending</option>
                <option value="approved" {{ $st=='approved' ? 'selected':'' }}>approved</option>
                <option value="rejected" {{ $st=='rejected' ? 'selected':'' }}>rejected</option>
            </select>
        </div>

        <button class="btn btn-success">{{ isset($booking) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
