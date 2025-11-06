<?php

// Lokasi File: app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI

class Review extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['reviewer_name', 'review_text'];

    protected $fillable = [
        'reviewer_name',
        'review_text',
        'rating',
        'reviewer_photo', // <-- TAMBAHKAN INI
        'is_visible',     // <-- TAMBAHKAN INI
    ];

    /**
     * Boot the model.
     * Hapus foto lama jika model dihapus.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($review) {
            if ($review->reviewer_photo) {
                // Hapus file dari 'storage/app/public/reviews'
                Storage::disk('public')->delete($review->reviewer_photo);
            }
        });
    }

    /**
     * Accessor untuk mendapatkan URL foto.
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->reviewer_photo) {
            // Mengembalikan URL publik ke file di 'storage/app/public/reviews'
            return Storage::url($this->reviewer_photo);
        }

        // Kembalikan placeholder jika tidak ada foto
        // Kita gunakan UI Avatars untuk inisial nama
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->getTranslation('reviewer_name', 'en')) . '&color=FFFFFF&background=003366';
    }
}