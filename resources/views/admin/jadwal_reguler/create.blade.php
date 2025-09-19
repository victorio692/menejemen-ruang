@extends('layouts.app')

@section('title', 'Tambah Jadwal Reguler')

@section('content')
    <div class="container">
        <h3 class="mb-4">Tambah Jadwal Reguler</h3>

        <form action="{{ route('admin.jadwal_reguler.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Room</label>
                <select name="room_id" class="form-control" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Hari</label>
                <input type="text" name="hari" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jam Mulai</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jam Selesai</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>

    </div>
@endsection
