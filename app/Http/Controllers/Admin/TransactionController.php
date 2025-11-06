<?php
// app/Http/Controllers/Admin/TransactionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Maatwebsite\Excel\Facades\Excel; // <-- DITAMBAHKAN
use App\Exports\TransactionExport;   // <-- DITAMBAHKAN

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data transaksi terbaru, paginasi 15 per halaman
        $transactions = Transaction::latest('date')->paginate(15);

        // Hitung total pemasukan
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        
        // Hitung total pengeluaran
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        
        // Hitung saldo akhir
        $balance = $totalIncome - $totalExpense;

        // Kirim semua data ke view
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya menampilkan view form tambah data
        return view('admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        // Buat data baru berdasarkan data yang sudah divalidasi oleh TransactionRequest
        Transaction::create($request->validated());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.transactions.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Kita tidak perlu halaman 'show' (detail) terpisah,
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Tampilkan view form edit dengan data transaksi yang dipilih
        return view('admin.transactions.edit', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        // Update data transaksi berdasarkan data yang sudah divalidasi
        $transaction->update($request->validated());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.transactions.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Hapus data transaksi
        $transaction->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.transactions.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Tampilkan halaman untuk Print
     */
    public function print()
    {
        // Ambil SEMUA data transaksi, diurutkan berdasarkan tanggal terbaru
        $transactions = Transaction::latest('date')->get(); // Menggunakan get() bukan paginate()

        // Hitung total pemasukan
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        
        // Hitung total pengeluaran
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        
        // Hitung saldo akhir
        $balance = $totalIncome - $totalExpense;

        // Kirim semua data ke view PRINT
        return view('admin.transactions.print', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
        ]);
    }

    /**
     * METHOD BARU UNTUK EXPORT EXCEL
     */
    public function exportExcel()
    {
        // Panggil class export kita dan download filenya
        return Excel::download(new TransactionExport, 'laporan_keuangan_'.now()->format('Y-m-d').'.xlsx');
    }
}