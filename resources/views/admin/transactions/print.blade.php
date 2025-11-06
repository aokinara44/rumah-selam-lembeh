<?php
// resources/views/admin/transactions/print.blade.php
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Print Financial Report - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
            .bg-gray-50 {
                background-color: transparent !important;
            }
            .shadow-md {
                box-shadow: none !important;
            }
            .rounded-lg {
                border-radius: 0 !important;
            }
            .border-b {
                border: none !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="container mx-auto p-4 sm:p-8">
        
        <div class="no-print mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to Report
            </a>
            <button onclick="window.print()" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Print this Page
            </button>
        </div>

        <div id="print-area" class="bg-white p-4 sm:p-6 shadow-md rounded-lg">
            
            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Financial Report</h1>
                <p class="text-xs sm:text-sm text-gray-500">Generated on: {{ now()->format('d F Y H:i') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 border-b pb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Income</h3>
                    <p class="text-lg sm:text-2xl font-semibold text-green-600">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Expense</h3>
                    <p class="text-lg sm:text-2xl font-semibold text-red-600">Rp {{ number_format($totalExpense, 2, ',', '.') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Final Balance</h3>
                    <p class="text-lg sm:text-2xl font-semibold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                        Rp {{ number_format($balance, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- PERBAIKAN: Tambah whitespace-nowrap --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Date</th>
                            {{-- PERBAIKAN: Tambah whitespace-nowrap --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Description</th>
                            {{-- PERBAIKAN: Tambah whitespace-nowrap --}}
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Amount</th>
                            {{-- PERBAIKAN: Tambah whitespace-nowrap --}}
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Type</th>
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
                                    Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    @if ($transaction->type == 'income')
                                        <span class="font-semibold text-green-600">Income</span>
                                    @else
                                        <span class="font-semibold text-red-600">Expense</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>