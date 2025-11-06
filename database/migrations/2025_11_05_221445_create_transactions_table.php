<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_transactions_table.php

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Kolom untuk tanggal transaksi
            $table->string('description'); // Kolom untuk deskripsi/keterangan
            $table->decimal('amount', 15, 2); // Kolom untuk jumlah uang. WAJIB pakai decimal untuk presisi.
            $table->enum('type', ['income', 'expense']); // Kolom untuk jenis: 'income' (Pemasukan) atau 'expense' (Pengeluaran)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};