@extends('layouts.app')

@section('title', 'Tambah Jadwal Reguler')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Jadwal Reguler</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.jadwal_reguler.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">-- Pilih Room --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
            @error('room_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="hari">Hari</label>
            <input type="text" name="hari" id="hari" class="form-control" value="{{ old('hari') }}" required>
            @error('hari') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="start_time">Jam Mulai</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
            @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="end_time">Jam Selesai</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
            @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}">
            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.jadwal_reguler') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
