<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ScheduleController; 
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;

/*
|--------------------------------------------------------------------------
| GRUP 1: RUTE NON-LOCALE (ADMIN, AUTH, SISTEM)
|--------------------------------------------------------------------------
*/

// ==========================================================
// PERBAIKAN BUG LOGIN
// Rute Auth dipindahkan keluar dari middleware SetLocale
// ==========================================================
require __DIR__ . '/auth.php';

// Rute Admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware(SetLocale::class)->group(function () { // Middleware SetLocale HANYA untuk panel admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/dashboard/schedule-events', [DashboardController::class, 'getScheduleEvents'])->name('dashboard.events');

        Route::resource('service-categories', ServiceCategoryController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('gallery-categories', GalleryCategoryController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('users', UserController::class);
        Route::resource('contacts', ContactController::class);

        // --- Rute Keuangan ---
        Route::get('transactions/print', [TransactionController::class, 'print'])->name('transactions.print');
        
        // <-- BARIS INI DITAMBAHKAN -->
        Route::get('transactions/export-excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');

        Route::resource('transactions', TransactionController::class); 
        // ---------------------

        // --- Rute Jadwal ---
        Route::resource('schedules', ScheduleController::class); 
        // -------------------

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Rute Sistem
Route::get('/sitemap.xml', [SitemapController::class, 'generate'])->name('sitemap');


/*
|--------------------------------------------------------------------------
| GRUP 2: RUTE PUBLIK (WAJIB DENGAN LOCALE)
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(SetLocale::class) 
    ->group(function () {

        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::get('/services', [PageController::class, 'services'])->name('services');
        Route::get('/services/{categorySlug}', [PageController::class, 'servicesByCategory'])->name('services.category');
        Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
        
        Route::get('/explore', [PageController::class, 'explore'])->name('explore');
        Route::get('/explore/{pageSlug}', [PageController::class, 'exploreShow'])->name('explore.page');

        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

    });

/*
|--------------------------------------------------------------------------
| GRUP 3: REDIRECT (PENANGKAP)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $locale = session('locale', config('app.fallback_locale', 'en'));
    return redirect()->route('home', ['locale' => $locale]);
});

Route::get('/{path}', function ($path) {
    
    $publicPaths = ['services', 'gallery', 'explore', 'contact'];
    
    $locale = session('locale', config('app.fallback_locale', 'en'));

    if (in_array($path, $publicPaths)) {
        return redirect(url($locale . '/' . $path));
    }

    if (preg_match('/^services\/([a-z0-9-]+)$/', $path, $matches)) {
        $categorySlug = $matches[1];
        return redirect()->route('services.category', ['locale' => $locale, 'categorySlug' => $categorySlug]);
    }

    if (preg_match('/^explore\/([a-z0-9-]+)$/', $path, $matches)) {
        $pageSlug = $matches[1];
        return redirect()->route('explore.page', ['locale' => $locale, 'pageSlug' => $pageSlug]);
    }

    abort(404);

})->where('path', '^(?!admin|login|logout|register|forgot-password|reset-password|sitemap\.xml|_ignition|storage|build|favicon\.ico).*$');