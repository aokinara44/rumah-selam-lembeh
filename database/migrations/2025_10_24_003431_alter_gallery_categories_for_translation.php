// database/migrations/YYYY_MM_DD_HHMMSS_alter_gallery_categories_for_translation.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gallery_categories', function (Blueprint $table) {
            // Ubah kolom 'name' menjadi TEXT agar bisa menampung JSON terjemahan
            $table->text('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_categories', function (Blueprint $table) {
            // Kembalikan menjadi string jika di-rollback
            // HATI-HATI: Ini bisa menyebabkan kehilangan data terjemahan
            $table->string('name')->change();
        });
    }
};