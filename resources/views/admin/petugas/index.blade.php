@extends('layouts.app')

@section('title', 'Manajemen Petugas')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen User</h3>

    <!-- Tombol kembali -->
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Tombol tambah petugas -->
    <a href="{{ route('admin.petugas.create') }}" class="btn btn-success mb-3 ms-2">Tambah Petugas</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($petugas as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->email }}</td>
                <td>
                    <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.petugas.delete', $p->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus petugas ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
