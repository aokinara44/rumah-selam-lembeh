<?php
// app/Http/Controllers/Admin/ServiceCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str facade

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::latest()->paginate(10);
        return view('admin.service-categories.index', compact('serviceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // !! PERBAIKAN VALIDASI !!
        $validated = $request->validate([
            'name' => 'required|array', // Pastikan 'name' adalah array
            'name.en' => 'required|string|max:255|unique:service_categories,name->en', // Validasi spesifik untuk EN + unique check
            'name.nl' => 'nullable|string|max:255', // Bahasa lain boleh kosong (nullable)
            'name.zh' => 'nullable|string|max:255',
        ]);

        // Generate slug dari nama Inggris
        $validated['slug'] = Str::slug($validated['name']['en']);

        // Spatie translatable akan otomatis handle array $validated['name']
        ServiceCategory::create($validated);

        return redirect()->route('admin.service-categories.index')
                         ->with('success', 'Service category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service-categories.edit', compact('serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
         // !! PERBAIKAN VALIDASI !!
         $validated = $request->validate([
            'name' => 'required|array', // Pastikan 'name' adalah array
            // Validasi spesifik untuk EN + unique check (abaikan ID saat ini)
            'name.en' => 'required|string|max:255|unique:service_categories,name->en,' . $serviceCategory->id, 
            'name.nl' => 'nullable|string|max:255', // Bahasa lain boleh kosong
            'name.zh' => 'nullable|string|max:255',
        ]);

        // Generate slug baru jika nama Inggris berubah
        if ($serviceCategory->getTranslation('name', 'en') !== $validated['name']['en']) {
            $validated['slug'] = Str::slug($validated['name']['en']);
        }

        // Spatie translatable akan otomatis handle array $validated['name']
        $serviceCategory->update($validated);

        return redirect()->route('admin.service-categories.index')
                         ->with('success', 'Service category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        // Tambahkan pengecekan jika kategori masih punya service
        if ($serviceCategory->services()->count() > 0) {
            return redirect()->route('admin.service-categories.index')
                             ->with('error', 'Cannot delete category because it still has associated services.');
        }
        
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
                         ->with('success', 'Service category deleted successfully.');
    }
}