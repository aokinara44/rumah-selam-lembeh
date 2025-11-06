<?php
// Lokasi File: resources/views/pages/divespots.blade.php
?>
<x-main-layout>
    {{-- SEO --}}
    @section('title', 'Lembeh Dive Spots - Rumah Selam Lembeh')
    @section('description', 'Explore the world-famous muck diving sites in Lembeh Strait with Rumah Selam Lembeh. Discover unique critters and dive spots on our interactive map.')

    {{-- ========================================================== --}}
    {{-- Hero Section (TETAP SAMA) --}}
    {{-- ========================================================== --}}
    <section
        x-data="{ images: {{ json_encode($heroImages ?? []) }}, current: 0, next() { if (this.images.length === 0) return; this.current = (this.current + 1) % this.images.length; }, init() { if (this.images.length > 1) { setInterval(() => { this.next() }, 5000); } } }"
        x-init="init()"
        class="absolute inset-x-0 top-0 h-[75vh] md:h-[80vh] bg-cover bg-center text-white flex items-center justify-center overflow-hidden"
    >
        <template x-for="(image, index) in images" :key="index">
            <div
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                :style="'background-image: url(\'' + '{{ asset('') }}' + image + '\');'"
                x-show="current === index"
                x-transition:enter="transition-opacity ease-in-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in-out duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            ></div>
        </template>
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh');"></div>
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center px-4 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold">{{ __('Lembeh Dive Spots') }}</h1>
            <p class="text-lg md:text-xl mt-2">{{ __('The Muck Diving Capital of the World.') }}</p>
        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- Wrapper Konten Utama (TETAP SAMA) --}}
    {{-- ========================================================== --}}
    <div class="mt-[75vh] md:mt-[80vh]">

        {{-- ========================================================== --}}
        {{-- Konten Dive Spots --}}
        {{-- ========================================================== --}}
        {{-- !! PERUBAHAN: Background kembali ke bg-white !! --}}
        <section class="py-20 lg:py-28 bg-white">
            <div class="container mx-auto px-6">

                {{-- Judul dan Deskripsi --}}
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-5">{{ __('Explore Lembeh Dive Sites') }}</h2>
                    <p class="text-gray-700 text-lg leading-relaxed mb-4">
                        {{ __("Lembeh Strait is globally renowned for its extraordinary muck diving. Discover a hidden world teeming with rare and unusual marine critters. Use the interactive map below to explore some of the most famous dive sites.") }}
                    </p>
                </div>

                {{-- Kontainer Peta Google My Maps --}}
                <div class="relative w-full max-w-5xl mx-auto border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden aspect-video mb-16">
                    {{-- !! PERUBAHAN: URL iframe diperbarui !! --}}
                    {{-- PASTIKAN SRC INI BENAR-BENAR URL MY MAPS EMBED YANG VALID --}}
                    <iframe
                        src="https://www.google.com/maps/d/embed?mid=1LM899nZl_RiWG0rh6399utb_zFA7HNI&ehbc=2E312F"
                        width="640"
                        height="480"
                        class="w-full h-full border-0"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                {{-- !! PERUBAHAN: Tombol CTA diganti FAQ & Support Section !! --}}
                {{-- Diambil dari reviews.blade.php --}}
                <div class="mt-16 pt-16 border-t border-gray-200"> {{-- Tambahkan pemisah atas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
                        {{-- Kolom Kiri: FAQ --}}
                        <div x-data="{ open: 'faq-1' }">
                            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('reviews.faq.title') }}</h2>
                            <div class="space-y-4">
                                {{-- FAQ 1 --}}
                                <div>
                                    <button @click="open = (open === 'faq-1' ? '' : 'faq-1')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-gray-50 hover:bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item1.question') }}</span>
                                        <svg class="w-5 h-5 text-blue-500 transform transition-transform duration-300" :class="{'rotate-180': open === 'faq-1'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open === 'faq-1'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mt-2 px-6 pb-4 text-gray-600">
                                        <p>{{ __('reviews.faq.item1.answer') }}</p>
                                    </div>
                                </div>
                                {{-- FAQ 2 --}}
                                <div>
                                    <button @click="open = (open === 'faq-2' ? '' : 'faq-2')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-gray-50 hover:bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item2.question') }}</span>
                                        <svg class="w-5 h-5 text-blue-500 transform transition-transform duration-300" :class="{'rotate-180': open === 'faq-2'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open === 'faq-2'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mt-2 px-6 pb-4 text-gray-600">
                                        <p>{{ __('reviews.faq.item2.answer') }}</p>
                                    </div>
                                </div>
                                {{-- FAQ 3 --}}
                                <div>
                                    <button @click="open = (open === 'faq-3' ? '' : 'faq-3')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-gray-50 hover:bg-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                        <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item3.question') }}</span>
                                        <svg class="w-5 h-5 text-blue-500 transform transition-transform duration-300" :class="{'rotate-180': open === 'faq-3'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open === 'faq-3'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mt-2 px-6 pb-4 text-gray-600">
                                        <p>{{ __('reviews.faq.item3.answer') }}</p>
                                    </div>
                                </div>
                                {{-- Tambahkan FAQ lain jika perlu --}}
                            </div>
                        </div>

                        {{-- Kolom Kanan: Support (Ask on WhatsApp) --}}
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('reviews.support.title') }}</h2>
                            {{-- Ubah sedikit styling box support --}}
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-lg shadow-md border-t-4 border-yellow-400">
                                <p class="text-gray-700 mb-6 leading-relaxed">{{ __('reviews.support.description') }}</p>
                                <a href="https://wa.me/6281238455307?text={{ urlencode(__('Hello, I have a question about the dive spots in Lembeh.')) }}" {{-- Teks WA disesuaikan --}}
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md transition-transform transform hover:scale-105 group">
                                    <svg class="w-6 h-6 mr-3 transform group-hover:rotate-[-12deg] transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.51 2 2 6.51 2 12.04c0 1.94.55 3.76 1.5 5.3L2 22l5.06-1.38c1.51.82 3.23 1.28 5.06 1.28C17.53 22 22 17.49 22 12.04S17.53 2 12.04 2zM17 15.65c-.21.08-.45.18-.72.26-.29.08-1.7-.63-1.99-.74-.29-.12-.51-.15-.72.15-.2.3-.85.74-1.04.85-.2.12-.4.15-.75.04-.3-.12-.66-.23-1.26-.59s-2.02-1.81-2.65-3.23c-.63-1.42-.07-2.18.42-2.67.43-.4.96-.98 1.15-1.28.19-.3.2-.56.09-.76-.09-.2-.29-.48-.4-.73-.12-.24-.26-.14-.52-.14-.26 0-.56-.04-.85-.04s-.68.11-.96.4C8.07 9.07 7.37 9.87 7.37 11.53c0 1.66 1.09 3.23 2.06 4.31.97 1.08 2.5 1.83 4.07 2.25 1.57.42 2.92.29 3.7-.22.78-.51 1.27-1.39 1.46-1.78.19-.38.19-.7-.08-.98z"/></svg>
                                    <span>{{ __('reviews.support.button') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- !! AKHIR BAGIAN FAQ & SUPPORT !! --}}

            </div>
        </section>

    </div>
</x-main-layout>