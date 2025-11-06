<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations; // <-- TAMBAHKAN IMPORT INI
use Illuminate\Support\Facades\Storage; // <-- Pastikan ini ada

class Gallery extends Model
{
    use HasFactory;
    use HasTranslations; // <-- TAMBAHKAN TRAIT INI

    public $translatable = ['title']; // <-- TAMBAHKAN ARRAY INI

    protected $fillable = [
        'gallery_category_id',
        'title', // <-- TAMBAHKAN 'title' DI SINI
        'image_path',
    ];

    public function galleryCategory()
    {
        return $this->belongsTo(GalleryCategory::class);
    }

    /**
     * Hapus file gambar terkait saat model dihapus.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gallery) {
            // Hapus file dari storage jika ada
            if ($gallery->image_path) {
                // Asumsi 'public' disk. Ubah 'public' jika disk-nya beda.
                Storage::disk('public')->delete($gallery->image_path);
            }
        });
    }
}