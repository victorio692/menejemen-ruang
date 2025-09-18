@extends('layouts.app')

@section('title', 'Edit Room')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Room</h3>

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Room</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity) }}" required min="1">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $room->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.rooms') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
