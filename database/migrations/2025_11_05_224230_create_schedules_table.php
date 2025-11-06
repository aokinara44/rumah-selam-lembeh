<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_schedules_table.php

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul acara/jadwal
            $table->text('description')->nullable(); // Deskripsi (opsional)
            $table->dateTime('start_time'); // Waktu mulai
            $table->dateTime('end_time'); // Waktu selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};