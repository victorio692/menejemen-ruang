@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit User</h3>

    <form action="{{ route('admin.petugas.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User / Peminjam</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.petugas') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@endsection
