@extends('layouts.app')

@section('title', 'Manajemen Jadwal Reguler')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Jadwal Reguler</h3>

    <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    <a href="{{ route('petugas.jadwal_reguler.create') }}" class="btn btn-success mb-3 ms-2">Tambah Jadwal</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Ruang</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Kegiatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $index => $j)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $j->room->name ?? '-' }}</td>
                <td>{{ ucfirst($j->hari) }}</td>
                <td>{{ $j->jam_mulai }}</td>
                <td>{{ $j->jam_selesai }}</td>
                <td>{{ $j->kegiatan }}</td>
                <td>
                    <form action="{{ route('petugas.jadwal_reguler.delete', $j->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada jadwal reguler.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
