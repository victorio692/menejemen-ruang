@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="vh-100 d-flex align-items-center justify-content-center" style="background: #f5f7fa;">
        <div class="card shadow-lg rounded-4 d-flex flex-row"
            style="width: 600px; max-width: 90%; min-height: 350px; overflow: hidden;">

            {{-- Kiri: Gambar --}}
            <div class="d-none d-md-flex flex-grow-1 align-items-center justify-content-center"
                style="background: linear-gradient(135deg, #6c63ff, #43a4ff);">
                <img src="{{ asset('images/login-illustration.png') }}" alt="Login Illustration" class="img-fluid"
                    style="max-height: 80%; max-width: 80%;">
            </div>

            {{-- Kanan: Form --}}
            <div class="flex-grow-1 p-4 d-flex flex-column justify-content-center" style="background-color: #ffffff;">
                {{-- Logo --}}
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 60px; height: 60px;">
                    <h4 class="fw-bold mt-2 text-primary">Login</h4>
                </div>

                {{-- Pesan Error / Success --}}
                @if (session('error'))
                    <div class="alert alert-danger mb-2">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mb-2">{{ session('success') }}</div>
                @endif

                {{-- Form --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm"
                            placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control form-control-sm"
                            placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-sm fw-semibold mb-2">
                        Login
                    </button>
                </form>

                <div class="text-center mt-1">
                    Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-primary">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6c63ff, #43a4ff);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5746c6, #2065c0);
        }

        input.form-control {
            border-radius: 10px;
            padding: 8px 12px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        @media(max-width: 768px) {
            .d-none.d-md-flex {
                display: none !important;
            }
        }
    </style>
@endsection
