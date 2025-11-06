<?php

// Lokasi File: app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // <-- Import yang hilang
use Illuminate\Support\Facades\App; // <-- Import yang hilang
use Illuminate\Support\Facades\Config; // <-- Import yang hilang
use Illuminate\Support\Facades\Session; // <-- Import yang hilang
use Symfony\Component\HttpFoundation\Response; // <-- Import yang hilang

class SetLocale
{
    /**
     * Handle an incoming request.
     * Hanya mengatur locale aplikasi jika parameter {locale} ada di URL,
     * atau menggunakan session/fallback jika tidak ada.
     * Middleware ini TIDAK boleh melakukan redirect.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = Config::get('app.available_locales', []);
        $fallbackLocale = Config::get('app.fallback_locale', 'en');

        // Ambil locale dari PARAMETER ROUTE (e.g., $request->route('locale')), 
        // BUKAN dari segment ($request->segment(1)).
        // Ini penting agar middleware ini hanya bekerja saat dipanggil di grup route {locale}.
        $urlLocale = $request->route('locale'); 

        // Kasus 1: URL punya parameter {locale} (contoh: /en/services)
        if ($urlLocale && array_key_exists($urlLocale, $availableLocales)) {
            // Jika valid, set locale aplikasi dan simpan ke session
            App::setLocale($urlLocale);
            Session::put('locale', $urlLocale);
        } 
        // Kasus 2: URL TIDAK punya parameter {locale} (contoh: /admin, /login)
        else {
            // Kita gunakan locale dari session (jika ada), atau fallback.
            // Ini berguna agar admin panel tetap bisa multi-bahasa via session,
            // tanpa merusak URL.
            $locale = Session::get('locale', $fallbackLocale);
            
            if (array_key_exists($locale, $availableLocales)) {
                App::setLocale($locale);
            } else {
                App::setLocale($fallbackLocale);
            }
        }

        // Lanjutkan request ke controller atau middleware berikutnya
        return $next($request);
    }
}

