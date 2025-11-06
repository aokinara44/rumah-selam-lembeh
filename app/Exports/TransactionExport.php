<?php
// app/Exports/TransactionExport.php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk lebar kolom otomatis
use PhpOffice\PhpSpreadsheet\Shared\Date; // Untuk format tanggal
use PhpOffice\PhpSpreadsheet\Style\NumberFormat; // Untuk format angka
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TransactionExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        // Ambil semua data transaksi, urutkan dari yang terbaru
        return Transaction::query()->latest('date');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Ini adalah baris header di file Excel
        return [
            'ID',
            'Tanggal',
            'Deskripsi',
            'Tipe',
            'Jumlah (Rp)',
        ];
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    public function map($transaction): array
    {
        // Ini adalah data untuk setiap baris
        return [
            $transaction->id,
            Date::dateTimeToExcel($transaction->date), // Format tanggal untuk Excel
            $transaction->description,
            $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->amount, // Akan diformat oleh columnFormatting()
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        // Tentukan format spesifik untuk kolom
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Format kolom Tanggal (B)
            'E' => '"Rp "#,##0.00', // Format kolom Jumlah (E) sebagai Rupiah
        ];
    }
}