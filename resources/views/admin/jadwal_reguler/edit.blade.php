@extends('layouts.app')

@section('title', 'Edit Jadwal Reguler')

@section('content')
    <div class="container">
        <h3 class="mb-4">Edit Jadwal Reguler</h3>

        <form action="{{ route('admin.jadwal_reguler.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" class="form-control" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $jadwal->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <input type="text" name="hari" class="form-control" value="{{ $jadwal->hari }}" required>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">Jam Mulai</label>
                <input type="time" name="start_time" class="form-control" value="{{ $jadwal->start_time }}" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">Jam Selesai</label>
                <input type="time" name="end_time" class="form-control" value="{{ $jadwal->end_time }}" required>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="{{ $jadwal->keterangan }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.jadwal_reguler') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
