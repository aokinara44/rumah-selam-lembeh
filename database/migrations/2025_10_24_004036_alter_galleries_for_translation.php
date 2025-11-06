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
        Schema::table('galleries', function (Blueprint $table) {
            // !! PERBAIKAN: Bukan ->change(), tapi TAMBAHKAN kolom baru !!
            // Kita tambahkan ->after() agar posisinya rapi di database
            // Kita tambahkan ->nullable() untuk keamanan jika sudah ada data di tabel galleries
            $table->text('title')->after('gallery_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // !! PERBAIKAN: Jika rollback, hapus kolomnya !!
            $table->dropColumn('title');
        });
    }
};