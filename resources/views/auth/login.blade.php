@extends('layouts.auth')

@section('title', 'Login - Menejemen Ruang')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">🏢</div>
        <h2 class="auth-title">Selamat Datang</h2>
        <p class="auth-subtitle">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Error Alert -->
    @if (session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST">
        @csrf

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

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
    </form>

    <div class="auth-footer">
        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
    </div>
</div>
@endsection
