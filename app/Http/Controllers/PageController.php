<?php

// Lokasi File: app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service; // <-- Ditambahkan
use App\Models\Review; // <-- Ditambahkan
use App\Models\GalleryCategory; // <-- Ditambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    /**
     * Mengambil daftar gambar hero dari folder public.
     * Mengembalikan URL absolut menggunakan asset().
     */
    private function getHeroImages(): array
    {
        $heroImages = [];
        $heroPath = public_path('images/hero');
        $relativePath = 'images/hero';

        if (File::isDirectory($heroPath)) {
            $files = File::files($heroPath);
            foreach ($files as $file) {
                $heroImages[] = asset($relativePath . '/' . $file->getFilename());
            }
        }
        
        if (empty($heroImages)) {
            $heroImages[] = 'https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh';
        }
        return $heroImages;
    }

    /**
     * Menampilkan halaman Home.
     */
    public function home()
    {
        $featuredServices = Service::with('serviceCategory')->latest()->take(5)->get();
        
        // PERUBAHAN DI SINI: Mengambil SEMUA review, bukan hanya 5
        $allReviews = Review::where('is_visible', true)->latest()->get();
        
        $heroImages = $this->getHeroImages();
        
        // PERUBAHAN DI SINI: Mengganti 'latestReviews' menjadi 'allReviews'
        return view('welcome', compact('featuredServices', 'allReviews', 'heroImages'));
    }

    /**
     * Menampilkan halaman Services (Semua Kategori).
     */
    public function services()
    {
        $serviceCategories = ServiceCategory::with('services')->orderBy('name->en', 'asc')->get();
        $heroImages = $this->getHeroImages();
        return view('pages.services', compact('serviceCategories', 'heroImages'))->with('selectedCategory', null);
    }

    /**
     * Menampilkan halaman Services untuk kategori tertentu.
     */
    public function servicesByCategory(Request $request)
    {
        $categorySlug = $request->route('categorySlug');
        $trimmedSlug = trim($categorySlug ?? '');

        if (empty($trimmedSlug)) {
            abort(404);
        }

        $serviceCategory = ServiceCategory::where('slug', $trimmedSlug)->firstOrFail();
        $serviceCategory->load('services');
        $heroImages = $this->getHeroImages();
        
        return view('pages.services', compact('heroImages'))->with('selectedCategory', $serviceCategory);
    }

    /**
     * Menampilkan halaman Gallery.
     */
    public function gallery()
    {
        $galleryCategories = GalleryCategory::with('galleries')->orderBy('name->en', 'asc')->get();
        $heroImages = $this->getHeroImages();
        return view('pages.gallery', compact('galleryCategories', 'heroImages'));
    }

    /**
     * Menampilkan halaman Explore (Indeks Statis).
     */
    public function explore()
    {
         $heroImages = $this->getHeroImages();
         $viewName = 'pages.explore-index';

         if (!View::exists($viewName)) {
            abort(404);
         }
         return view($viewName, compact('heroImages'));
    }

    /**
     * Menampilkan halaman detail Explore statis berdasarkan slug.
     */
    public function exploreShow(Request $request)
    {
        $pageSlug = $request->route('pageSlug');
        $heroImages = $this->getHeroImages();
        $viewName = 'pages.explore.' . $pageSlug;

        if (!View::exists($viewName)) {
            abort(404);
        }

        return view($viewName, compact('heroImages'));
    }


    /**
     * Menampilkan halaman Reviews.
     * FUNGSI INI DIHAPUS KARENA SUDAH TIDAK DIPAKAI
     */
    /*
    public function reviews()
    {
        $reviews = \App\Models\Review::where('is_visible', true)->orderBy('created_at', 'desc')->paginate(10);
        $heroImages = $this->getHeroImages();
        return view('pages.reviews', compact('reviews', 'heroImages'));
    }
    */

    /**
     * Menampilkan halaman Contact.
     */
    public function contact()
    {
         $heroImages = $this->getHeroImages();
         return view('pages.contact', compact('heroImages'));
    }

    /**
     * Menangani submit form Contact.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // PERBAIKAN: Menghapus try-catch yang tidak perlu
        return redirect()->route('contact', ['locale' => app()->getLocale()])
                         ->with('success', __('contact.form.success'));
    }
}