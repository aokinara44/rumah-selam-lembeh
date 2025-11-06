<!DOCTYPE html>
{{-- Lokasi File: resources/views/layouts/app.blade.php --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')

        <style>
            [x-cloak] { display: none !important; }
            .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            .padding-transition { transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        </style>
    </head>
    <body class="font-sans antialiased">

        <div x-data="{
                sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true',
                toggleSidebar() {
                    this.sidebarMinimized = !this.sidebarMinimized;
                    localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
                }
            }"
             @toggle-sidebar.window="toggleSidebar()"
             {{-- Tidak perlu $watch lagi karena event window akan menangani --}}
             class="relative flex min-h-screen bg-gray-100">

            <aside x-cloak
                   id="sidebar-container"
                   class="fixed inset-y-0 left-0 z-40 flex h-screen flex-shrink-0 flex-col bg-white shadow-lg sidebar-transition"
                   :class="{ 'w-64': !sidebarMinimized, 'w-20': sidebarMinimized }">
                {{-- Kita tidak perlu pass state lagi, navigation akan baca localStorage sendiri --}}
                @include('layouts.navigation')
            </aside>

            <div class="flex-1 flex flex-col w-full padding-transition"
                 {{-- Gunakan x-bind:class agar padding awal benar --}}
                 x-bind:class="{ 'pl-64': !sidebarMinimized, 'pl-20': sidebarMinimized }">

                <header class="sticky top-0 z-30 bg-white shadow flex-shrink-0">
                    <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 items-center justify-between">
                            <button @click="$dispatch('toggle-sidebar')" title="{{ __('Toggle Sidebar') }}"
                                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /> </svg>
                            </button>
                            <div class="flex-grow ml-4">
                                @if (isset($header))
                                    {{ $header }}
                                @endif
                            </div>
                            <div class="ml-auto">
                                @include('layouts.partials.user-dropdown-header')
                            </div>
                        </div>
                    </div>
                </header>

                <div class="px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="w-full mt-4">
                           {{-- Konten notifikasi --}}
                           <div class="p-4 rounded-md bg-green-50 border border-green-300">
                               <div class="flex">
                                   <div class="flex-shrink-0">
                                       <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                       </svg>
                                   </div>
                                   <div class="ml-3">
                                       <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                   </div>
                               </div>
                           </div>
                        </div>
                    @endif
                    @if (session('error'))
                         <div class="w-full mt-4">
                           {{-- Konten notifikasi --}}
                           <div class="p-4 rounded-md bg-red-50 border border-red-300">
                               <div class="flex">
                                   <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                       </svg>
                                   </div>
                                   <div class="ml-3">
                                       <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                   </div>
                               </div>
                           </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="w-full mt-4">
                            {{-- Konten notifikasi --}}
                           <div class="p-4 rounded-md bg-red-50 border border-red-300">
                               <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">{{ __('Whoops! Something went wrong.') }}</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul role="list" class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <main class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>