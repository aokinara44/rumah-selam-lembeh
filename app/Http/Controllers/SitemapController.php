<?php

namespace App\Http\Controllers; // <-- Namespace-nya harus cocok

use Illuminate\Http\Request;

class SitemapController extends Controller // <-- Nama class harus cocok
{
    /**
     * Menampilkan halaman sitemap.xml.
     */
    public function generate()
    {
        // Logika untuk mengambil data (post, service, dll) akan ada di sini.
        
        // Nanti Anda harus membuat view, contoh:
        // return response()->view('sitemap', [
        //     'posts' => $posts,
        //     'services' => $services
        // ])->header('Content-Type', 'text/xml');

        // Untuk sekarang, ini sudah cukup untuk menghilangkan error "unknown class":
        return response("Sitemap coming soon.", 200)
               ->header('Content-Type', 'text/plain');
    }
}
