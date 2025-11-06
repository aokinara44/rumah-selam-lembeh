<?php
// Lokasi File: app/Http/Controllers/Admin/ServiceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str; // Pastikan ini di-import

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('serviceCategory')->latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ServiceCategory::orderBy('name->en')->get(); 
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'required|array|min:1', 
            'title.en' => 'required|string|max:255', 
            'title.nl' => 'nullable|string|max:255',
            'title.zh' => 'nullable|string|max:255',
            'description' => 'nullable|array',      
            'description.*' => 'nullable|string', 
            'content' => 'nullable|array',          
            'content.*' => 'nullable|string', 
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        // Generate slug dari title EN
        $validated['slug'] = Str::slug($validated['title']['en']);

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('services', 'public');
        }

        // Simpan data ke database
        Service::create($validated); 

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::orderBy('name->en')->get(); 
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'required|array|min:1',
            'title.en' => 'required|string|max:255', 
            'title.nl' => 'nullable|string|max:255',
            'title.zh' => 'nullable|string|max:255',
            'description' => 'nullable|array',      
            'description.*' => 'nullable|string',    
            'content' => 'nullable|array',          
            'content.*' => 'nullable|string',        
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        // Generate slug baru HANYA jika title EN berubah
        if ($service->getTranslation('title', 'en', false) !== $validated['title']['en']) {
             $validated['slug'] = Str::slug($validated['title']['en']);
        }

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            if ($service->featured_image && Storage::disk('public')->exists($service->featured_image)) {
                Storage::disk('public')->delete($service->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('services', 'public');
        }
        
        $service->update($validated);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->featured_image && Storage::disk('public')->exists($service->featured_image)) {
            Storage::disk('public')->delete($service->featured_image);
        }
        $service->delete();
        return redirect()->route('admin.services.index')
                         ->with('success', 'Service deleted successfully.');
    }
}