<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PetugasMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'petugas') {
            return $next($request);
        }
        return redirect('/login')->with('error', 'Akses ditolak. Hanya Petugas!');
    }
}
