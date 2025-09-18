@extends('layouts.app')

@section('title', 'Tambah Room')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Room</h3>

    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Room</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="capacity" class="form-control" required min="1">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.rooms') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
