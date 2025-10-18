@extends('layouts.app')

@section('title', 'Tambah Jadwal Reguler')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Jadwal Reguler</h3>

    <a href="{{ route('petugas.jadwal_reguler') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('petugas.jadwal_reguler.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="room_id" class="form-label">Ruang</label>
            <select name="room_id" id="room_id" class="form-select" required>
                <option value="">-- Pilih Ruang --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <select name="hari" id="hari" class="form-select" required>
                <option value="">-- Pilih Hari --</option>
                <option value="senin">Senin</option>
                <option value="selasa">Selasa</option>
                <option value="rabu">Rabu</option>
                <option value="kamis">Kamis</option>
                <option value="jumat">Jumat</option>
                <option value="sabtu">Sabtu</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kegiatan" class="form-label">Kegiatan</label>
            <input type="text" name="kegiatan" id="kegiatan" class="form-control" placeholder="Contoh: Kelas RPL 2" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
