<?php
// Lokasi File: resources/views/dashboard.blade.php
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- 1. SCRIPT DAN STYLE UNTUK FULLCALENDAR --}}
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                if (calendarEl) { 

                    var isMobile = window.innerWidth < 768; // Cek apakah layar mobile

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        // Tampilan default: listWeek jika mobile, dayGridMonth jika desktop
                        initialView: isMobile ? 'listWeek' : 'dayGridMonth', 
                        
                        // Memperpendek teks tombol untuk desktop
                        views: {
                            dayGridMonth: { buttonText: 'Month' }, 
                            listWeek: { buttonText: 'List' }     
                        },

                        // === PERBAIKAN HEADER TOOLBAR (SESUAI PERMINTAAN ANDA) ===
                        headerToolbar: isMobile ? {
                            // Tampilan Mobile: DIKUNCI ke list view, tidak ada tombol ganti view
                            left: 'title',
                            center: '',
                            right: 'prev,next' // Hanya navigasi, super bersih
                        } : {
                            // Tampilan Desktop: Tetap rapi dengan tombol teks pendek
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,listWeek' // Akan tampil sbg "Month | List"
                        },
                        // === AKHIR PERBAIKAN ===
                        
                        events: '{{ route("admin.dashboard.events", ["locale" => app()->getLocale()]) }}', 
                        editable: false, 
                        selectable: true,
                        dayMaxEvents: true, 
                        
                        eventClick: function(info) {
                            info.jsEvent.preventDefault(); 
                            if (info.event.url) {
                                window.open(info.event.url, "_self"); 
                            }
                        },
                    });
                    calendar.render(); 
                }
            });
        </script>
        
        <style>
            .fc .fc-button-primary {
                background-color: #3b82f6; border-color: #3b82f6; color: white;
            }
            .fc .fc-button-primary:hover {
                background-color: #2563eb; border-color: #2563eb;
            }
            .fc .fc-daygrid-day.fc-day-today {
                background-color: #eff6ff; 
            }
            .fc {
                font-size: 0.85em;
            }
            .fc-list-event-title {
                white-space: normal !important; 
            }
            /* Beri jarak antar grup tombol */
            .fc .fc-button-group {
                gap: 4px;
            }
             /* Pastikan header di mobile tidak wrap */
            .fc .fc-header-toolbar.fc-toolbar {
                display: flex;
                flex-wrap: nowrap; /* Mencegah tombol turun */
                justify-content: space-between;
            }
            .fc .fc-toolbar-chunk {
                display: flex;
                align-items: center;
                gap: 4px; /* Jarak antar tombol */
            }
        </style>
    @endpush


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">Berikut adalah ringkasan aktivitas di website Anda.</p>
                </div>
            </div>

            {{-- 4 Kartu Statistik LIVE --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                {{-- Saldo Keuangan (LIVE) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 11.21 12.77 10.5 12 10.5c-.77 0-1.536.71-2.121 1.256-.586.544-.586 1.43 0 1.974l.879.659z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">Saldo Keuangan</dt>
                                <dd class="text-2xl font-semibold text-gray-900">Rp {{ number_format($balance, 0, ',', '.') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Akan Datang (LIVE) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">Jadwal Akan Datang</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $upcomingSchedulesCount }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Layanan (LIVE) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Layanan</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $serviceCount }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Total Ulasan (LIVE) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.31h5.518a.562.562 0 01.31.95l-4.22 3.07a.564.564 0 00-.17.618l1.58 4.722a.563.563 0 01-.815.618L12.001 15.3a.563.563 0 00-.618 0l-4.22 3.072a.563.563 0 01-.815-.618l1.58-4.722a.564.564 0 00-.17-.618l-4.22-3.07a.562.562 0 01.31-.95h5.518a.563.563 0 00.475-.31l2.125-5.111z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Ulasan</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $reviewCount }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Area 2 Kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KOLOM KIRI: Cashflow Summary --}}
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Ringkasan Cashflow</h3>
                        <div class="overflow-x-auto"> 
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Pemasukan</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Hari Ini</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-green-600 font-semibold text-right">+ Rp {{ number_format($dailyIncome, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600 font-semibold text-right">- Rp {{ number_format($dailyExpense, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Minggu Ini</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-green-600 font-semibold text-right">+ Rp {{ number_format($weeklyIncome, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600 font-semibold text-right">- Rp {{ number_format($weeklyExpense, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Bulan Ini</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-green-600 font-semibold text-right">+ Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600 font-semibold text-right">- Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Kalender Jadwal --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Kalender Jadwal</h3>
                        <div id="calendar"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>