// database/migrations/YYYY_MM_DD_HHMMSS_drop_deprecated_tables.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hapus tabel yang tidak terpakai.
     */
    public function up(): void
    {
        // Hapus 'posts' dulu karena ada foreign key ke 'post_categories'
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('bookings');
    }

    /**
     * Reverse the migrations.
     * Buat kembali tabel jika di-rollback.
     */
    public function down(): void
    {
        // Buat kembali tabel post_categories
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Buat kembali tabel posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_category_id')->constrained('post_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('featured_image')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Buat kembali tabel bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_guests');
            $table->string('service_type');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }
};