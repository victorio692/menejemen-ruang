@extends('layouts.auth')

@section('title', 'Register - Menejemen Ruang')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">📝</div>
        <h2 class="auth-title">Buat Akun Baru</h2>
        <p class="auth-subtitle">Daftar untuk menggunakan aplikasi</p>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="form-errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Register Form -->
    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Masukkan password Anda" required>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" 
                   placeholder="Konfirmasi password Anda" required>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-person-plus me-2"></i>Buat Akun
        </button>
    </form>

    <div class="auth-footer">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>
</div>
@endsection
