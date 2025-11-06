<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Review;
use App\Models\Transaction; 
use App\Models\Schedule; 
use Illuminate\Http\Request;
use Carbon\Carbon; 
use Carbon\CarbonInterface; 
use Illuminate\Support\Facades\DB; // <-- DITAMBAHKAN UNTUK FIX

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data statistik.
     */
    public function index()
    {
        $now = Carbon::now();

        // 1. Data Statistik (Stat Cards)
        $serviceCount = Service::count();
        $galleryCount = Gallery::count();
        $reviewCount = Review::count();
        $upcomingSchedulesCount = Schedule::where('start_time', '>=', $now)->count();

        // 2. Data Keuangan (Total Saldo untuk Stat Card)
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // 3. DATA BARU: Ringkasan Cashflow untuk tabel (berdasarkan kolom 'date')
        
        // Harian (PERBAIKAN: Menggunakan where() + DB::raw() untuk menghindari error linter)
        $dailyIncome = Transaction::where('type', 'income')->where(DB::raw('DATE(date)'), '=', $now->today()->toDateString())->sum('amount');
        $dailyExpense = Transaction::where('type', 'expense')->where(DB::raw('DATE(date)'), '=', $now->today()->toDateString())->sum('amount');

        // Mingguan (PERBAIKAN: Menggunakan CarbonInterface)
        $weeklyIncome = Transaction::where('type', 'income')->whereBetween('date', [$now->startOfWeek(CarbonInterface::MONDAY), $now->endOfWeek(CarbonInterface::SUNDAY)])->sum('amount');
        $weeklyExpense = Transaction::where('type', 'expense')->whereBetween('date', [$now->startOfWeek(CarbonInterface::MONDAY), $now->endOfWeek(CarbonInterface::SUNDAY)])->sum('amount');

        // Bulanan
        $monthlyIncome = Transaction::where('type', 'income')->whereYear('date', $now->year)->whereMonth('date', $now->month)->sum('amount');
        $monthlyExpense = Transaction::where('type', 'expense')->whereYear('date', $now->year)->whereMonth('date', $now->month)->sum('amount');


        // Kirim semua data yang telah diambil ke view 'dashboard'
        return view('dashboard', compact(
            'serviceCount',
            'galleryCount',
            'reviewCount',
            'balance', 
            'upcomingSchedulesCount',
            'dailyIncome',      
            'dailyExpense',     
            'weeklyIncome',     
            'weeklyExpense',    
            'monthlyIncome',    
            'monthlyExpense'    
        ));
    }

    /**
     * Method baru untuk mengambil data jadwal sebagai JSON untuk FullCalendar.
     */
    public function getScheduleEvents(Request $request)
    {
        // Ambil semua jadwal
        $schedules = Schedule::all();

        // Format data agar sesuai dengan FullCalendar
        $events = $schedules->map(function ($schedule) {
            return [
                'title' => $schedule->title,
                'start' => $schedule->start_time->toIso8601String(), // Format '2023-11-10T10:00:00'
                'end' => $schedule->end_time->toIso8601String(),
                'url' => route('admin.schedules.edit', ['locale' => app()->getLocale(), 'schedule' => $schedule->id]), // Link ke halaman edit
                'description' => $schedule->description
            ];
        });

        // Kembalikan sebagai JSON
        return response()->json($events);
    }
}