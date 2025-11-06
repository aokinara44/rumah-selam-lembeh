<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations; // Pastikan ini di-import

class Service extends Model
{
    use HasFactory, HasTranslations; // Gunakan HasTranslations

    protected $fillable = [
        'service_category_id',
        'title', 
        'description', 
        'content', 
        'featured_image',
        'slug', // !! TAMBAHKAN 'slug' DI SINI !!
    ];

    // Kolom yang bisa diterjemahkan
    public $translatable = ['title', 'description', 'content'];

    /**
     * Relasi ke ServiceCategory.
     */
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * Override route model binding key
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
