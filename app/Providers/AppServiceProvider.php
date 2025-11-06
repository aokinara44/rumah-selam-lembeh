<?php

// Lokasi File: app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache; // 1. TAMBAHKAN
use Illuminate\Support\Str;
use App\Models\ServiceCategory;
use App\Models\Contact; // 2. TAMBAHKAN

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 3. PERUBAHAN UTAMA: Tambahkan 'pages.contact' ke dalam array
        View::composer(['layouts.main', 'pages.contact'], function ($view) {

            // Waktu cache: 1 detik (debug) atau 24 jam (produksi)
            $cacheTime = config('app.debug') ? 1 : 60 * 60 * 24;

            $serviceCategoriesForNav = ServiceCategory::orderBy('name->en', 'asc')
                ->select('id', 'name', 'slug')
                ->get();

            $exploreCategoriesForNav = $this->getExploreNavItems();

            // 4. TAMBAHKAN KEMBALI LOGIKA KONTAK
            $siteContacts = Cache::remember('site_contacts', $cacheTime, function () {
                // Ambil semua kontak yang aktif
                // Urutkan berdasarkan nama (agar konsisten)
                // Lalu kelompokkan berdasarkan 'type' (phone, email, social, address, qr_code)
                return Contact::where('is_active', true)
                                ->orderBy('name')
                                ->get()
                                ->groupBy('type');
            });

            $view->with('serviceCategoriesForNav', $serviceCategoriesForNav)
                ->with('exploreCategoriesForNav', $exploreCategoriesForNav)
                ->with('siteContacts', $siteContacts); // 5. TAMBAHKAN VARIABEL INI KE VIEW
        });
    }

    /**
     * Mengambil item navigasi Explore dengan memindai folder views
     * dan menyimpannya di cache.
     */
    private function getExploreNavItems(): array
    {
        $cacheKey = 'explore_nav_items';
        $cacheTime = config('app.debug') ? 1 : 60 * 60 * 24; // 1 detik (debug) atau 24 jam (produksi)

        return Cache::remember($cacheKey, $cacheTime, function () {
            $items = [];
            $path = resource_path('views/pages/explore');

            if (!File::isDirectory($path)) {
                return [];
            }

            $files = File::files($path);

            foreach ($files as $file) {
                // --- AWAL PERBAIKAN ---
                $filename = $file->getFilename(); // Cth: "diving.blade.php"

                // 1. Kita cek manual untuk file .blade.php
                if (Str::endsWith($filename, '.blade.php')) {

                    // 2. Ambil nama file sebelum ".blade.php"
                    $slug = Str::before($filename, '.blade.php'); // Cth: "diving"

                    // 3. Lewati file 'index' jika ada (agar tidak jadi sub-menu)
                    if ($slug === 'index') {
                        continue;
                    }

                    // 4. Ganti ->ucwords() menjadi ->title() (Fix error asli)
                    $name = Str::of($slug)
                        ->replace('-', ' ')
                        ->replace('_', ' ')
                        ->title(); // Cth: "Diving"

                    $items[] = [
                        'name' => (string) $name,
                        'slug' => $slug,
                    ];
                }
                // --- AKHIR PERBAIKAN ---
            }

            return $items;
        });
    }
}