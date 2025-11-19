@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-items-center mb-4 gap-3">
        <h3 class="fw-bold mb-0">Manajemen User</h3>
        <div class="d-grid gap-2 gap-md-3 w-100 w-md-auto d-md-flex">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Tambah User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->role === 'petugas' ? 'bg-primary' : 'bg-info' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.petugas.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.petugas.delete', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
