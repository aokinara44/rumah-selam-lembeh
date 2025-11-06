<?php
// resources/views/admin/transactions/_form.blade.php
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
    
    {{-- Kolom Tanggal --}}
    <div class="space-y-2">
        <x-input-label for="date" :value="__('Date')" />
        <x-text-input 
            id="date" 
            name="date" 
            type="date" 
            class="mt-1 block w-full" 
            :value="old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : now()->format('Y-m-d'))" 
            required 
        />
        <x-input-error class="mt-2" :messages="$errors->get('date')" />
    </div>

    {{-- Kolom Tipe Transaksi (Income/Expense) --}}
    <div class="space-y-2">
        <x-input-label for="type" :value="__('Type')" />
        <select 
            id="type" 
            name="type" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
            required
        >
            <option value="income" @selected(old('type', $transaction->type ?? '') == 'income')>
                {{ __('Income') }}
            </option>
            <option value="expense" @selected(old('type', $transaction->type ?? '') == 'expense')>
                {{ __('Expense') }}
            </option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('type')" />
    </div>

    {{-- Kolom Deskripsi --}}
    <div class="space-y-2 md:col-span-2">
        <x-input-label for="description" :value="__('Description')" />
        <x-text-input 
            id="description" 
            name="description" 
            type="text" 
            class="mt-1 block w-full" 
            :value="old('description', $transaction->description ?? '')" 
            required 
            placeholder="e.g., Payment from client, Office supplies"
        />
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    {{-- Kolom Jumlah (Amount) --}}
    <div class="space-y-2 md:col-span-2">
        <x-input-label for="amount" :value="__('Amount')" />
        <div class="relative mt-1 rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm">Rp</span>
            </div>
            <x-text-input 
                id="amount" 
                name="amount" 
                type="number" 
                class="block w-full pl-10" 
                :value="old('amount', $transaction->amount ?? '')" 
                required 
                placeholder="0.00"
                step="0.01" 
            />
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
    </div>
</div>