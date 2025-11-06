<?php

// Lokasi File: app/Models/ServiceCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceCategory extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug'; // Memberitahu Laravel untuk menggunakan 'slug' untuk Route Model Binding
    }
}
