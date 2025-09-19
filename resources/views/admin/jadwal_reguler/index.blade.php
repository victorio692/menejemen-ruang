@extends('layouts.app')

@section('title', 'Manajemen Jadwal Reguler')

@section('content')
    <div class="container">
        <h3 class="mb-4">Manajemen Jadwal Reguler</h3>

        <a href="{{ route('admin.jadwal_reguler.create') }}" class="btn btn-success mb-3">Tambah Jadwal</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Hari</th>
                    <th>Room</th>
                    <th>Waktu</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ $item->room->name ?? '-' }}</td>
                        <td>{{ $item->start_time }} - {{ $item->end_time }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.jadwal_reguler.edit', $item->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.jadwal_reguler.delete', $item->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada jadwal reguler.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
