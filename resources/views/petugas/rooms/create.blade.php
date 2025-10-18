@extends('layouts.app')

@section('title', 'Tambah Room')

@section('content')
<div class="container">
    <h3>Tambah Room</h3>
    <form action="{{ route('petugas.rooms.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Room</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="capacity" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
