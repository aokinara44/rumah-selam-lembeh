<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- TAMBAHKAN IMPORT INI

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleryCategories = GalleryCategory::latest()->paginate(10);
        return view('admin.gallery-categories.index', compact('galleryCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // !! PERBAIKAN VALIDASI !!
        $validated = $request->validate([
            'name' => 'required|array', // Pastikan 'name' adalah array
            'name.en' => 'required|string|max:255|unique:gallery_categories,name->en', // Validasi spesifik untuk EN + unique check
            'name.nl' => 'nullable|string|max:255', // Bahasa lain boleh kosong (nullable)
            'name.zh' => 'nullable|string|max:255',
        ]);

        // Generate slug dari nama Inggris
        $validated['slug'] = Str::slug($validated['name']['en']);

        // Spatie translatable akan otomatis handle array $validated['name']
        // !! PERBAIKAN BUG: Harusnya GalleryCategory, bukan ServiceCategory !!
        GalleryCategory::create($validated);

        return redirect()->route('admin.gallery-categories.index')
                         ->with('success', 'Gallery category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        // !! PERBAIKAN VALIDASI !!
        $validated = $request->validate([
            'name' => 'required|array', // Pastikan 'name' adalah array
            // Validasi spesifik untuk EN + unique check (abaikan ID saat ini)
            'name.en' => 'required|string|max:255|unique:gallery_categories,name->en,' . $galleryCategory->id,
            'name.nl' => 'nullable|string|max:255', // Bahasa lain boleh kosong
            'name.zh' => 'nullable|string|max:255',
        ]);

        // Generate slug baru jika nama Inggris berubah
        if ($galleryCategory->getTranslation('name', 'en') !== $validated['name']['en']) {
            $validated['slug'] = Str::slug($validated['name']['en']);
        }

        // Spatie translatable akan otomatis handle array $validated['name']
        $galleryCategory->update($validated);

        return redirect()->route('admin.gallery-categories.index')
                         ->with('success', 'Gallery category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryCategory $galleryCategory)
    {
        // !! TAMBAHKAN PENGECEKAN !!
        if ($galleryCategory->galleries()->count() > 0) {
            return redirect()->route('admin.gallery-categories.index')
                             ->with('error', 'Cannot delete category because it still has associated galleries.');
        }
        
        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')
                         ->with('success', 'Gallery category deleted successfully.');
    }
}