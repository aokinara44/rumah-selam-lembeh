<?php
// Lokasi File: resources/views/layouts/main.blade.php
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Rumah Selam Lembeh Dive Center')</title>
    <meta name="description"
        content="@yield('description', 'Rumah Selam Lembeh is a local-owned dive operator in the famous Lembeh Strait, offering friendly budget diving services with a focus on safety and unforgettable critter moments.')">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')

</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">

    @php
        $navigationItems = [
            'home' => __('Home'),
            'services' => __('Services'),
            'gallery' => __('Gallery'),
            'reviews' => __('Reviews'),
            'explore' => __('Explore'),
        ];
    @endphp

    <div x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window.passive="scrolled = (window.pageYOffset > 30)">
        <header
            :class="{
                'bg-gradient-to-r from-blue-900 to-blue-700 shadow-lg text-white': scrolled || mobileMenuOpen,
                'bg-transparent text-white': !scrolled && !mobileMenuOpen
            }"
            class="fixed w-full z-50 transition-all duration-300 ease-in-out py-2.5 md:py-3" x-ref="header">
            <nav class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
                    class="flex-shrink-0 transition-all duration-300">
                    <div class="flex flex-col items-start leading-none">
                        <div class="font-bold tracking-[0.1em] transition-all duration-300 text-shadow-subtle"
                            :class="{ 'text-xl md:text-2xl': !scrolled, 'text-lg md:text-xl': scrolled }">
                            <span class="logo-rumah">RUMAH</span> <span class="logo-selam">SELAM</span>
                        </div>
                        <div class="transition-all duration-300 overflow-hidden"
                            :class="{ 'max-h-5': !scrolled, 'max-h-4': scrolled }">
                            <span class="logo-subtitle block text-shadow-subtle" :class="{ 'scrolled': scrolled }"><span
                                    class="logo-divecenter">DIVE CENTER</span><span
                                    class="logo-pipe mx-1">|</span><span class="logo-sulawesi">NORTH
                                    SULAWESI</span></span>
                        </div>
                    </div>
                </a>

                <div class="hidden md:flex flex-grow justify-center items-center space-x-7 lg:space-x-10">

                    @foreach ($navigationItems as $routeKey => $label)
                        @if ($routeKey === 'services')
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                                <button
                                    class="flex items-center text-white text-base font-medium pb-1 border-b-2 transition duration-300 ease-in-out hover:text-yellow-300 hover:border-yellow-300 focus:outline-none text-shadow-subtle {{ request()->routeIs('services*') ? 'border-yellow-400 text-yellow-300' : 'border-transparent' }}">
                                    <span>{{ $label }}</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path> </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute left-1/2 transform -translate-x-1/2 mt-1 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20 text-gray-700" style="display: none;">
                                    <div class="py-1" role="menu" aria-orientation="vertical">
                                        @isset($serviceCategoriesForNav)
                                            @foreach($serviceCategoriesForNav as $category)
                                                <a href="{{ route('services.category', ['locale' => app()->getLocale(), 'categorySlug' => $category->slug]) }}"
                                                class="dropdown-item {{ request()->routeIs('services.category') && request()->route('categorySlug') == $category->slug ? 'dropdown-item-active' : '' }}"
                                                role="menuitem">{{ $category->name }}</a>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        @elseif ($routeKey === 'explore')
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                                <button
                                    class="flex items-center text-white text-base font-medium pb-1 border-b-2 transition duration-300 ease-in-out hover:text-yellow-300 hover:border-yellow-300 focus:outline-none text-shadow-subtle {{ request()->routeIs('explore*') ? 'border-yellow-400 text-yellow-300' : 'border-transparent' }}">
                                    <span>{{ $label }}</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path> </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute left-1/2 transform -translate-x-1/2 mt-1 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20 text-gray-700" style="display: none;">
                                    <div class="py-1" role="menu" aria-orientation="vertical">
                                        @isset($exploreCategoriesForNav)
                                            @foreach($exploreCategoriesForNav as $item)
                                                <a href="{{ route('explore.page', ['locale' => app()->getLocale(), 'pageSlug' => $item['slug']]) }}"
                                                class="dropdown-item {{ request()->routeIs('explore.page') && request()->route('pageSlug') == $item['slug'] ? 'dropdown-item-active' : '' }}"
                                                role="menuitem">{{ $item['name'] }}</a>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        @else
                            @php
                                $url = $routeKey === 'reviews'
                                    ? route('home', ['locale' => app()->getLocale()]) . '/#reviews'
                                    : route($routeKey, ['locale' => app()->getLocale()]);
                            @endphp
                            <a href="{{ $url }}"
                                class="text-white text-base font-medium pb-1 border-b-2 transition duration-300 ease-in-out hover:text-yellow-300 hover:border-yellow-300 text-shadow-subtle {{ request()->routeIs($routeKey) ? 'border-yellow-400 text-yellow-300' : 'border-transparent' }}">
                                {{ $label }}
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <div x-data="{ langOpen: false }" class="relative">
                        <button @click="langOpen = !langOpen"
                            class="flex items-center text-white hover:text-yellow-300 transition duration-300 focus:outline-none text-shadow-subtle"
                            aria-label="Change language" :aria-expanded="langOpen" aria-haspopup="true"
                            id="lang-switcher-button">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h1a2 2 0 002-2v-1a2 2 0 012-2h1.945M10 3v1m0 16v1m4-18v1m0 16v1M3 10h1m16 0h1M4 14h1m14 0h1M4 7h1m14 0h1M7 4h1m8 0h1m-9 16h1m8 0h1"></path></svg>
                            <span class="ml-1 text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="langOpen" @click.away="langOpen = false" x-transition
                            class="absolute right-0 mt-2 w-36 bg-white rounded-md shadow-lg py-1 z-20 text-gray-700"
                            style="display: none;" role="menu" aria-labelledby="lang-switcher-button">
                            @php
                                $currentParams = request()->route() ? request()->route()->parameters() : [];
                                unset($currentParams['locale']);
                                $currentRouteName = request()->route() ? request()->route()->getName() : 'home';
                            @endphp
                            @foreach (config('app.available_locales') as $localeCode => $localeName)
                                @php $newParams = array_merge(['locale' => $localeCode], $currentParams); @endphp
                                <a href="{{ route($currentRouteName, $newParams) }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 {{ app()->getLocale() == $localeCode ? 'font-semibold bg-gray-50' : '' }}"
                                    role="menuitem">
                                    {{ $localeName }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                        class="bg-yellow-400 text-gray-900 px-5 py-1.5 rounded-full font-semibold hover:bg-yellow-500 transition duration-300 ease-in-out shadow hover:shadow-md text-sm">{{ __('Contact Us') }}</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button @click.stop="mobileMenuOpen = !mobileMenuOpen"
                        class="p-1 text-white focus:outline-none" aria-label="Open main menu"
                        :aria-expanded="mobileMenuOpen">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </nav>
        </header>

        <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-full"
            class="md:hidden fixed inset-y-0 left-0 w-72 bg-blue-800/95 backdrop-blur-sm p-6 pt-20 shadow-xl overflow-y-auto"
            style="display: none; z-index: 40 !important;">
            <button @click="mobileMenuOpen = false" class="absolute top-4 right-4 text-white p-1 focus:outline-none" aria-label="Close menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="flex flex-col space-y-1">

                @foreach ($navigationItems as $routeKey => $label)
                    @if ($routeKey === 'services')
                        <div x-data="{ open: {{ request()->routeIs('services*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="flex items-center justify-between w-full mobile-nav-link">
                                <span>{{ $label }}</span>
                                <svg class="w-5 h-5 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" class="mt-1 space-y-1" style="display: none;">
                                @isset($serviceCategoriesForNav)
                                    @foreach($serviceCategoriesForNav as $category)
                                        <a href="{{ route('services.category', ['locale' => app()->getLocale(), 'categorySlug' => $category->slug]) }}"
                                        class="mobile-accordion-item {{ request()->routeIs('services.category') && request()->route('categorySlug') == $category->slug ? 'mobile-accordion-item-active' : '' }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    @elseif ($routeKey === 'explore')
                         <div x-data="{ open: {{ request()->routeIs('explore*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="flex items-center justify-between w-full mobile-nav-link">
                                <span>{{ $label }}</span>
                                <svg class="w-5 h-5 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" class="mt-1 space-y-1" style="display: none;">
                                @isset($exploreCategoriesForNav)
                                    @foreach($exploreCategoriesForNav as $item)
                                        <a href="{{ route('explore.page', ['locale' => app()->getLocale(), 'pageSlug' => $item['slug']]) }}"
                                            class="mobile-accordion-item {{ request()->routeIs('explore.page') && request()->route('pageSlug') == $item['slug'] ? 'mobile-accordion-item-active' : '' }}">
                                            {{ $item['name'] }}
                                        </a>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    @else
                        @php
                            $url = $routeKey === 'reviews'
                                ? route('home', ['locale' => app()->getLocale()]) . '/#reviews'
                                : route($routeKey, ['locale' => app()->getLocale()]);
                        @endphp
                        <a href="{{ $url }}"
                            class="{{ request()->routeIs($routeKey) ? 'mobile-nav-link-active' : 'mobile-nav-link' }}">
                            {{ $label }}
                        </a>
                    @endif
                @endforeach

                <div class="border-t border-blue-700/50 pt-5 mt-5">
                    <h3 class="px-3 text-sm font-medium text-blue-300 uppercase tracking-wider mb-3">{{ __('Language') }}</h3>
                    <div class="space-y-1">
                        @php
                            $currentParamsMobile = request()->route() ? request()->route()->parameters() : [];
                            unset($currentParamsMobile['locale']);
                            $currentRouteNameMobile = request()->route() ? request()->route()->getName() : 'home';
                        @endphp
                        @foreach (config('app.available_locales') as $locale => $localeName)
                            @php $newParamsMobile = array_merge(['locale' => $locale], $currentParamsMobile); @endphp
                            <a href="{{ route($currentRouteNameMobile, $newParamsMobile) }}" class="{{ app()->getLocale() == $locale ? 'mobile-lang-link-active' : 'mobile-lang-link' }}">
                                <span class="w-6 mr-2 text-center opacity-75">{{ strtoupper($locale) }}</span>
                                <span>{{ $localeName }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                    class="bg-yellow-400 text-gray-900 px-6 py-2.5 rounded-full font-semibold hover:bg-yellow-500 transition duration-300 ease-in-out mt-8 text-center text-base shadow-md">{{ __('Contact Us') }}</a>
            </div>
        </div>
    </div>

    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <div class="relative bg-gradient-to-t from-blue-900 to-blue-800 text-gray-300">
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none"
                class="relative block w-[calc(100%+1.3px)] h-[60px] md:h-[80px] text-gray-50">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="fill-current"></path>
            </svg>
        </div>
        <footer class="pt-20 md:pt-24 pb-8">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <div class="sm:col-span-2 lg:col-span-1 flex flex-col items-center sm:items-start text-center sm:text-left">
                        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="mb-4"><img
                                src="{{ asset('images/logo.png') }}" alt="Rumah Selam Logo"
                                class="h-20 w-auto" width="80" height="80"></a>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            {{ __('Your premier destination for muck diving in the Lembeh Strait. Experience the best of underwater biodiversity with us.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-base font-semibold mb-4 tracking-wider uppercase text-gray-100">
                            {{ __('Navigate') }}</p>
                        <ul class="space-y-2.5 text-sm">
                            @foreach ($navigationItems as $routeKey => $label)
                                @php
                                    $url = $routeKey === 'reviews'
                                        ? route('home', ['locale' => app()->getLocale()]) . '/#reviews'
                                        : route($routeKey, ['locale' => app()->getLocale()]);
                                @endphp
                                <li><a href="{{ $url }}" class="text-gray-300 hover:text-yellow-400 transition">{{ $label }}</a></li>
                            @endforeach
                            <li><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="text-gray-300 hover:text-yellow-400 transition">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-base font-semibold mb-4 tracking-wider uppercase text-gray-100">
                            {{ __('Contact') }}</p>
                        
                        {{-- ============================================= --}}
                        {{-- START PERUBAHAN FOOTER (KONTAK) --}}
                        {{-- ============================================= --}}
                        <ul class="space-y-2.5 text-sm text-gray-300">
                            @if(isset($siteContacts['address']) && $siteContacts['address']->isNotEmpty())
                                @foreach($siteContacts['address'] as $address)
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-1 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                    <a href="https://maps.app.goo.gl/ufBVhMSHQpiWezw5A" class="hover:text-yellow-400 transition">{{ $address->value }}</a>
                                </li>
                                @endforeach
                            @else
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-1 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                    <span>{{ __('Address not available') }}</span>
                                </li>
                            @endif

                            @if(isset($siteContacts['phone']) && $siteContacts['phone']->isNotEmpty())
                                @foreach($siteContacts['phone'] as $phone)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->value) }}" class="hover:text-yellow-400 transition">{{ $phone->value }}</a>
                                </li>
                                @endforeach
                            @endif
                            
                            @if(isset($siteContacts['email']) && $siteContacts['email']->isNotEmpty())
                                @foreach($siteContacts['email'] as $email)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> 
                                    <a href="mailto:{{ $email->value }}" class="hover:text-yellow-400 transition">{{ $email->value }}</a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        {{-- ============================================= --}}
                        {{-- AKHIR PERUBAHAN FOOTER (KONTAK) --}}
                        {{-- ============================================= --}}

                    </div>
                    <div>
                        <p class="text-base font-semibold mb-4 tracking-wider uppercase text-gray-100">
                            {{ __('Follow Us') }}</p>
                        
                        {{-- ============================================= --}}
                        {{-- START PERUBAHAN FOOTER (SOSIAL MEDIA) --}}
                        {{-- ============================================= --}}
                        <div class="flex space-x-5">
                            @if(isset($siteContacts['social']) && $siteContacts['social']->isNotEmpty())
                                @foreach($siteContacts['social'] as $social)
                                    <a href="{{ $social->value }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-yellow-400 transition duration-300" aria-label="Follow us on {{ $social->name }}">
                                        @if($social->icon_svg)
                                            {!! $social->icon_svg !!} {{-- Ini akan merender SVG Anda --}}
                                        @else
                                            {{-- Fallback jika tidak ada SVG --}}
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.5 0-2 2-2h2V2h-4c-4 0-5 3-5 5v2H7.5v4H10v7h4v-7z" /></svg>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                {{-- Menampilkan ikon default jika tidak ada data, agar layout tidak rusak --}}
                                <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-300" aria-label="Follow us on Facebook">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.5 0-2 2-2h2V2h-4c-4 0-5 3-5 5v2H7.5v4H10v7h4v-7z" /></svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-pink-500 transition duration-300" aria-label="Follow us on Instagram">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.5-11.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm-5 1.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5zm0 5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                        </div>
                        {{-- ============================================= --}}
                        {{-- AKHIR PERUBAHAN FOOTER (SOSIAL MEDIA) --}}
                        {{-- ============================================= --}}

                        {{-- ============================================= --}}
                        {{-- START PERUBAHAN FOOTER (KODE QR) --}}
                        {{-- ============================================= --}}
                        @if(isset($siteContacts['qr_code']) && $siteContacts['qr_code']->isNotEmpty())
                            @foreach($siteContacts['qr_code'] as $qr)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-200">{{ $qr->name }}</p>
                                    <img src="{{ asset($qr->value) }}" alt="{{ $qr->name }} QR Code" class="w-24 h-24 mt-2 rounded-md bg-white p-1">
                                </div>
                            @endforeach
                        @endif
                        {{-- ============================================= --}}
                        {{-- AKHIR PERUBAHAN FOOTER (KODE QR) --}}
                        {{-- ============================================= --}}
                    </div>
                </div>
                <div class="mt-10 border-t border-gray-700/50 pt-6 text-center text-gray-500 text-sm">©
                    {{ date('Y') }} Rumah Selam Lembeh Dive Center. All Rights Reserved.</div>
            </div>
        </footer>
    </div>

    <div x-data="{ scrolled: false }" @scroll.window.passive="scrolled = (window.pageYOffset > 100)">
        <button x-show="scrolled" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-transition
            class="fixed bottom-6 right-6 bg-yellow-400 hover:bg-yellow-500 text-gray-800 p-2.5 rounded-full shadow-lg z-50 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 focus:ring-offset-gray-900"
            style="display: none;" aria-label="Scroll back to top">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
        </button>
    </div>

    @stack('scripts')
</body>
</html>