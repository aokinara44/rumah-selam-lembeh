// database/migrations/2025_10_23_190312_alter_columns_for_translation.php
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
        // REVISI: Ubah kolom 'title' (bukan 'name') di tabel 'services'
        Schema::table('services', function (Blueprint $table) {
            $table->text('title')->change(); // <-- DIUBAH DARI 'name'
        });

        // Ini sudah benar (sesuai migrasi create_service_categories_table)
        Schema::table('service_categories', function (Blueprint $table) {
            $table->text('name')->change();
        });

        // Ini sudah benar (sesuai migrasi create_gallery_categories_table)
        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->text('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // REVISI: Kembalikan 'title' (bukan 'name') ke string
        Schema::table('services', function (Blueprint $table) {
            $table->string('title')->change(); // <-- DIUBAH DARI 'name'
        });

        Schema::table('service_categories', function (Blueprint $table) {
            $table->string('name')->change();
        });

        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }
};