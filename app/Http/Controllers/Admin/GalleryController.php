<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('galleryCategory')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GalleryCategory::all(); 
        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // !! PERUBAHAN VALIDASI !!
        $validated = $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'title.nl' => 'nullable|string|max:255',
            'title.zh' => 'nullable|string|max:255',
            // Validasi untuk 'images' (bukan 'image')
            'images' => 'required|array', // Pastikan 'images' adalah array
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validasi setiap file di dalam array
        ]);
        // !! AKHIR PERUBAHAN VALIDASI !!


        // !! PERUBAHAN LOGIKA PENYIMPANAN !!
        
        // Kita siapkan data yang sama untuk semua gambar
        // (Isinya 'gallery_category_id' dan 'title')
        $dataToCreate = $validated;
        
        // Hapus array 'images' dari data utama, 
        // karena 'images' tidak ada di tabel database
        unset($dataToCreate['images']);

        // Looping untuk setiap file yang di-upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // 1. Simpan file
                $path = $file->store('galleries', 'public');
                
                // 2. Tambahkan path gambar ke data
                $dataToCreate['image_path'] = $path;

                // 3. Buat entri di database
                // (Menggunakan 'title' dan 'category_id' yang sama)
                Gallery::create($dataToCreate);
            }
        }
        // !! AKHIR PERUBAHAN LOGIKA PENYIMPANAN !!

        return redirect()->route('admin.galleries.index')
                         ->with('success', 'Gallery item(s) created successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
                         ->with('success', 'Gallery item deleted successfully.');
    }
}