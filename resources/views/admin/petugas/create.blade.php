@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah User</h3>

    <form action="{{ route('admin.petugas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="petugas">Petugas</option>
                <option value="user">User / Peminjam</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.petugas') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
