@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="vh-100 d-flex align-items-center justify-content-center" style="background: #f5f7fa;">
        <div class="card shadow-lg rounded-4 d-flex flex-row"
            style="width: 600px; max-width: 90%; min-height: 350px; overflow: hidden;">

            {{-- Kiri: Gambar --}}
            <div class="d-none d-md-flex flex-grow-1 align-items-center justify-content-center"
                style="background: linear-gradient(135deg, #6c63ff, #43a4ff);">
                <img src="{{ asset('images/register-illustration.png') }}" alt="Register Illustration" class="img-fluid"
                    style="max-height: 80%; max-width: 80%;">
            </div>

            {{-- Kanan: Form --}}
            <div class="flex-grow-1 p-4 d-flex flex-column justify-content-center" style="background-color: #ffffff;">
                {{-- Logo --}}
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 60px; height: 60px;">
                    <h4 class="fw-bold mt-2 text-primary">Register</h4>
                </div>

                {{-- Pesan Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="name" class="form-control form-control-sm"
                            placeholder="Masukkan nama" required>
                    </div>
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
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm"
                            placeholder="Konfirmasi password" required>
                    </div>
                    <button class="btn btn-success w-100 btn-sm fw-semibold mb-2">
                        Register
                    </button>
                </form>

                <div class="text-center mt-1">
                    Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-primary">Login di sini</a>
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

        .btn-success {
            background: linear-gradient(135deg, #28a745, #2ecc71);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #27ae60);
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
