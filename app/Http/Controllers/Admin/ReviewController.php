<?php

// Lokasi File: app/Http/Controllers/Admin/ReviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reviewer_name' => 'required|array',
            'reviewer_name.en' => 'required|string|max:255',
            'reviewer_name.nl' => 'nullable|string|max:255',
            'reviewer_name.zh' => 'nullable|string|max:255',

            'review_text' => 'required|array',
            'review_text.en' => 'required|string',
            'review_text.nl' => 'nullable|string',
            'review_text.zh' => 'nullable|string',

            'rating' => 'required|integer|min:1|max:5',
            'is_visible' => 'nullable|boolean', // <-- TAMBAHKAN INI
            'reviewer_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // <-- TAMBAHKAN INI
        ]);

        // Handle 'is_visible' checkbox (jika tidak dicentang, tidak akan ada di request)
        $validatedData['is_visible'] = $request->has('is_visible');

        // Handle file upload
        if ($request->hasFile('reviewer_photo')) {
            $path = $request->file('reviewer_photo')->store('reviews', 'public');
            $validatedData['reviewer_photo'] = $path;
        }

        Review::create($validatedData);

        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
         $validatedData = $request->validate([
            'reviewer_name' => 'required|array',
            'reviewer_name.en' => 'required|string|max:255',
            'reviewer_name.nl' => 'nullable|string|max:255',
            'reviewer_name.zh' => 'nullable|string|max:255',

            'review_text' => 'required|array',
            'review_text.en' => 'required|string',
            'review_text.nl' => 'nullable|string',
            'review_text.zh' => 'nullable|string',

            'rating' => 'required|integer|min:1|max:5',
            'is_visible' => 'nullable|boolean', // <-- TAMBAHKAN INI
            'reviewer_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // <-- TAMBAHKAN INI
        ]);

        // Handle 'is_visible' checkbox
        $validatedData['is_visible'] = $request->has('is_visible');

        // Handle file upload
        if ($request->hasFile('reviewer_photo')) {
            // 1. Hapus foto lama jika ada
            if ($review->reviewer_photo) {
                Storage::disk('public')->delete($review->reviewer_photo);
            }

            // 2. Upload foto baru
            $path = $request->file('reviewer_photo')->store('reviews', 'public');
            $validatedData['reviewer_photo'] = $path;
        }

        $review->update($validatedData);

        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Foto akan otomatis terhapus karena event 'deleting' pada Model
        $review->delete();

        return redirect()->route('admin.reviews.index')
                         ->with('success', 'Review deleted successfully.');
    }
}