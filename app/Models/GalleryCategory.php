<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations; // <-- TAMBAHKAN IMPORT INI

class GalleryCategory extends Model
{
    use HasFactory;
    use HasTranslations; // <-- TAMBAHKAN TRAIT INI

    public $translatable = ['name']; // <-- TAMBAHKAN ARRAY INI

    protected $fillable = [
        'name',
        'slug',
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}