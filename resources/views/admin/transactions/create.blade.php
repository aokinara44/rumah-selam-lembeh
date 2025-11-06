<?php
// resources/views/admin/transactions/create.blade.php
?>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Transaction') }}
            </h2>
            <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('admin.transactions.store', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        
                        {{-- Memanggil file form partial yang tadi kita buat --}}
                        @include('admin.transactions._form')

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>