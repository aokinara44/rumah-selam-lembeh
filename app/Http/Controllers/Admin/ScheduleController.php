<?php
// app/Http/Controllers/Admin/ScheduleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Http\Requests\ScheduleRequest; // <-- Gunakan Request yang baru kita buat
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua jadwal, urutkan dari yang paling dekat (waktu mulai)
        // dan tampilkan 15 per halaman
        $schedules = Schedule::oldest('start_time')->paginate(15);

        // Tampilkan view index (yang akan kita buat nanti)
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan view form create
        return view('admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request)
    {
        // Buat jadwal baru dari data yang sudah tervalidasi
        Schedule::create($request->validated());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.schedules.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        // Tidak kita gunakan untuk admin panel
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        // Tampilkan view form edit dengan data jadwal yang dipilih
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        // Update jadwal dari data yang sudah tervalidasi
        $schedule->update($request->validated());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.schedules.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        // Hapus jadwal
        $schedule->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.schedules.index', ['locale' => app()->getLocale()])
                         ->with('success', 'Schedule deleted successfully.');
    }
}