@extends('layouts.app')

@section('title', 'Daftar Room Petugas')

@section('content')
<div class="container">
    <h3>Daftar Room</h3>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    <a href="{{ route('petugas.rooms.create') }}" class="btn btn-success mb-3">Tambah Room</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Room</th>
                <th>Kapasitas</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $room->name }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->description }}</td>
                <td>
                    <form action="{{ route('petugas.rooms.delete', $room->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus room?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
