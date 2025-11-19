<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==================== WEB METHODS ====================
    
    // Tampilkan form login WEB
    public function loginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            \Log::info('Web login attempt', [
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Logout WEB
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // Tampilkan form register WEB
    public function registerForm()
    {
        return view('auth.register');
    }

    // Proses register WEB (HANYA UNTUK USER)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // Buat petugas (Admin only) - VIA WEB
    public function createPetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // HANYA VIA WEB
        ]);

        return redirect()->route('admin.petugas')->with('success', 'Akun petugas berhasil dibuat!');
    }

    // ==================== MOBILE API METHODS ====================

    // Login untuk MOBILE (API) - HANYA UNTUK USER
    public function mobileLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // HANYA USER YANG BISA LOGIN VIA MOBILE
            if ($user->role !== 'user') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya user yang bisa login via mobile aplikasi'
                ], 403);
            }
            
            $token = $user->createToken('mobile-token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah'
        ], 401);
    }

    // Register untuk MOBILE (API) - HANYA UNTUK USER
    public function mobileRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // OTOMATIS USER UNTUK MOBILE
        ]);

        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'token' => $token
        ], 201);
    }

    // Logout untuk MOBILE (API)
    public function mobileLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    // Get user profile untuk MOBILE (API)
    public function mobileProfile(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }
}