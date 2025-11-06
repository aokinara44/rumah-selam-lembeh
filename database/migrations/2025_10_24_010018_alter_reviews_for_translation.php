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
        Schema::table('reviews', function (Blueprint $table) {
            // Ubah kolom 'reviewer_name' menjadi TEXT agar bisa menampung JSON terjemahan
            $table->text('reviewer_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Kembalikan menjadi string jika di-rollback
            $table->string('reviewer_name')->change();
        });
    }
};