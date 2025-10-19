@extends('layouts.app')

@section('title', 'Manajemen Jadwal Reguler')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Jadwal Reguler</h3>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    <a href="{{ route('admin.jadwal_reguler.create') }}" class="btn btn-success mb-3">Tambah Jadwal</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        // Kelompokkan jadwal berdasarkan nama room (kelas)
        $grouped = $jadwal->groupBy(fn($item) => $item->room->nama_room ?? 'Tidak Ada Kelas');
    @endphp

    @forelse ($grouped as $kelas => $items)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>{{ strtoupper($kelas) }}</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ $item->start_time }} - {{ $item->end_time }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.jadwal_reguler.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.jadwal_reguler.delete', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-warning text-center">
            Belum ada jadwal reguler.
        </div>
    @endforelse
</div>
@endsection
