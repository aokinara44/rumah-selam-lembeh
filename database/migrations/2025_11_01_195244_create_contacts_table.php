// database/migrations/YYYY_MM_DD_HHMMSS_create_contacts_table.php
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Untuk admin, misal: "WhatsApp Admin", "Instagram"
            $table->string('type'); // Tipe kontak: 'phone', 'email', 'social', 'address'
            $table->text('value'); // Isinya: nomor telepon, link, email, atau alamat
            $table->text('icon_svg')->nullable(); // Untuk menyimpan kode SVG ikon (opsional)
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};