@extends('layouts.app')

@section('title', 'Manajemen Room')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Room</h3>

    <a href="{{ route('admin.rooms.create') }}" class="btn btn-success mb-3">Tambah Room</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama Room</th>
                <th>Kapasitas</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $index => $room)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ $room->description }}</td>
                <td>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.rooms.delete', $room->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus Room ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data room</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
