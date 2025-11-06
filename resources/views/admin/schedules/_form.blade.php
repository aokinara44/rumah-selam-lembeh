<?php
// resources/views/admin/schedules/_form.blade.php
?>

{{-- Tampilkan error validasi --}}
@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-3 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    {{-- Kolom Judul --}}
    <div class="space-y-2 md:col-span-2">
        <x-input-label for="title" :value="__('Event Title')" />
        <x-text-input 
            id="title" 
            name="title" 
            type="text" 
            class="mt-1 block w-full" 
            :value="old('title', $schedule->title ?? '')" 
            required 
            autofocus
            placeholder="e.g., Staff Meeting, Client Dive Schedule"
        />
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
    </div>

    {{-- Kolom Waktu Mulai --}}
    <div class="space-y-2">
        <x-input-label for="start_time" :value="__('Start Time')" />
        <x-text-input 
            id="start_time" 
            name="start_time" 
            type="datetime-local" 
            class="mt-1 block w-full" 
            :value="old('start_time', isset($schedule) ? $schedule->start_time->format('Y-m-d\TH:i') : '')" 
            required 
        />
        <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
    </div>

    {{-- Kolom Waktu Selesai --}}
    <div class="space-y-2">
        <x-input-label for="end_time" :value="__('End Time')" />
        <x-text-input 
            id="end_time" 
            name="end_time" 
            type="datetime-local" 
            class="mt-1 block w-full" 
            :value="old('end_time', isset($schedule) ? $schedule->end_time->format('Y-m-d\TH:i') : '')" 
            required 
        />
        <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
    </div>

    {{-- Kolom Deskripsi --}}
    <div class="space-y-2 md:col-span-2">
        <x-input-label for="description" :value="__('Description (Optional)')" />
        <textarea 
            id="description" 
            name="description" 
            rows="4"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
            placeholder="Add any additional details here..."
        >{{ old('description', $schedule->description ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>
</div>