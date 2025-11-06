<?php
// resources/views/admin/transactions/index.blade.php
?>
<x-app-layout>
    <x-slot name="header">
        {{-- 
            PERBAIKAN: 
            Mengubah layout header agar selalu 'flex-row' (berdampingan)
            di semua ukuran layar (mobile dan desktop).
        --}}
        <div class="flex flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Report') }}
            </h2>

            {{-- Grup Tombol Aksi: HANYA TOMBOL TAMBAH --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:w-auto">
                {{-- Tombol Tambah Transaksi --}}
                <a href="{{ route('admin.transactions.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('+ Add Transaction') }}
                </a>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        {{-- Padding responsif --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Menampilkan pesan sukses --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 1. Bagian Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Income</h3>
                        <p class="text-2xl sm:text-3xl font-semibold text-green-600">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Expense</h3>
                        <p class="text-2xl sm:text-3xl font-semibold text-red-600">Rp {{ number_format($totalExpense, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Final Balance</h3>
                        <p class="text-2xl sm:text-3xl font-semibold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                            Rp {{ number_format($balance, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. Bagian Tabel Transaksi --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Description</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Amount</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($transactions as $transaction)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $transaction->date->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $transaction->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                    @if ($transaction->type == 'income')
                                                        <span class="font-semibold text-green-600">+ Rp {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                                    @else
                                                        <span class="font-semibold text-red-600">- Rp {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('admin.transactions.edit', ['locale' => app()->getLocale(), 'transaction' => $transaction->id]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    
                                                    <form action="{{ route('admin.transactions.destroy', ['locale' => app()->getLocale(), 'transaction' => $transaction->id]) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                                    No transactions found.
                                                </td>
                                            </tr>
                                        {{-- PERBAIKAN: Penutup yang benar adalah @endforelse --}}
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Grup Tombol Aksi di Bawah Tabel --}}
            <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-2">
                
                {{-- Tombol Download Excel --}}
                <a href="{{ route('admin.transactions.export.excel', ['locale' => app()->getLocale()]) }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Download Excel') }}
                </a>

                {{-- Tombol Print --}}
                <a href="{{ route('admin.transactions.print', ['locale' => app()->getLocale()]) }}" 
                   target="_blank" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Print Report') }}
                </a>
            </div>

            {{-- 4. Bagian Paginasi --}}
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</x-app-layout>