<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; // 1. Import Route
use Illuminate\Support\Facades\URL;   // 2. Import URL
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // --- INI ADALAH PERBAIKANNYA ---
                
                // 1. Ambil locale dari session, default ke 'en'
                $locale = session('locale', config('app.fallback_locale', 'en'));

                // 2. Tentukan rute tujuan (home atau dashboard admin)
                // Jika rutenya 'admin.dashboard', kita tidak perlu locale karena sudah di-handle di web.php
                // Jika rutenya 'home', kita tambahkan parameter locale
                
                $redirectRoute = 'home'; // Default redirect
                
                if (Route::has('admin.dashboard')) {
                    // Jika user adalah admin, mungkin kita redirect ke admin dashboard?
                    // Untuk saat ini, kita asumsikan semua redirect ke 'home'
                    // Jika Anda punya logika admin, kita bisa tambahkan di sini.
                }

                // 3. Buat URL redirect dengan parameter locale
                return redirect(route($redirectRoute, ['locale' => $locale]));
                
                // --- AKHIR PERBAIKAN ---
            }
        }

        return $next($request);
    }
}