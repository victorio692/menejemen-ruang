<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip session check untuk AJAX requests dan API
        if ($request->ajax() || $request->is('api/*')) {
            return $next($request);
        }

        // Skip session check untuk logout route
        if ($request->is('logout') || $request->is('*/logout')) {
            return $next($request);
        }

        // Check if session has expired
        if (!$request->hasSession()) {
            return $next($request);
        }

        // For authenticated users, check session timeout
        if (auth()->check()) {
            $lastActivity = session('last_activity');
            $sessionTimeout = (config('session.lifetime') * 60); // Convert to seconds

            // Only check if last_activity is set
            if ($lastActivity && (time() - $lastActivity) > $sessionTimeout) {
                // Session expired, logout user
                auth()->logout();
                session()->invalidate();
                session()->regenerateToken();

                // Redirect to login with message
                return redirect()->route('login')
                    ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }

            // Update last activity timestamp
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
