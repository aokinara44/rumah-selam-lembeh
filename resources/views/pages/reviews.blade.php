<?php
// Lokasi File: resources/views/pages/reviews.blade.php
?>
<x-main-layout>
    @section('title', 'Guest Reviews - Rumah Selam Lembeh')
    @section('description', 'See what our guests have to say about their diving experiences with Rumah Selam Lembeh Dive Center.')

    {{-- ========================================================== --}}
    {{-- Hero Section with Slideshow (Header Transparan) --}}
    {{-- ========================================================== --}}
    <section
        {{-- Logika Alpine.js dari Anda --}}
        x-data="{ images: {{ json_encode($heroImages ?? []) }}, current: 0, next() { if (this.images.length === 0) return; this.current = (this.current + 1) % this.images.length; }, init() { if (this.images.length > 1) { setInterval(() => { this.next() }, 5000); } } }"
        x-init="init()"
        {{-- Kunci: Atur posisi absolute dan tinggi (h-[75vh] md:h-[80vh]) --}}
        class="absolute inset-x-0 top-0 h-[75vh] md:h-[80vh] bg-cover bg-center text-white flex items-center justify-center overflow-hidden"
    >
        <template x-for="(image, index) in images" :key="index">
            <div
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
                {{-- Menggunakan asset() helper dan path dari controller --}}
                :style="'background-image: url(\'' + '{{ asset('') }}' + image + '\');'"
                x-show="current === index"
                x-transition:enter="transition-opacity ease-in-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in-out duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
        </template>

        {{-- Fallback jika tidak ada gambar hero --}}
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh');"></div>

        <div class="absolute inset-0 bg-black opacity-50"></div>

        <div class="relative z-10 text-center px-4 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold">{{ __('reviews.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2">{{ __('reviews.header.description') }}</p>
        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- Wrapper Konten Utama (Mendorong Konten Ke Bawah) --}}
    {{-- ========================================================== --}}
    {{-- Kunci: Margin top harus sama dengan tinggi hero section --}}
    <div class="mt-[75vh] md:mt-[80vh]">

        {{-- Reviews Grid Section --}}
        <section class="py-20 bg-white"> {{-- Padding ditingkatkan ke py-20 --}}
            <div class="container mx-auto px-6">
                @if(!isset($reviews) || $reviews->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('reviews.fallback') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($reviews as $review)
                            <div x-data="{ expanded: false }" class="bg-gray-50 p-8 rounded-lg shadow-md border-l-4 border-blue-500 fade-in flex flex-col">
                                <div class="flex items-center mb-4">
                                    @if ($review->reviewer_photo)
                                        <img src="{{ Storage::url($review->reviewer_photo) }}" alt="{{ $review->reviewer_name }}" class="h-14 w-14 object-cover rounded-full flex-shrink-0">
                                    @else
                                        <div class="h-14 w-14 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 flex-shrink-0">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $review->reviewer_name }}</h4>
                                        <div class="flex items-center">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-5 h-5 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <p class="text-gray-600 italic mb-4 flex-grow" :class="{ 'line-clamp-3': !expanded }">"{{ $review->review_text }}"</p>

                                @if (strlen(strip_tags($review->review_text)) > 150)
                                <button @click="expanded = !expanded" class="text-sm text-blue-600 hover:text-blue-800 self-start mt-auto">
                                    <span x-show="!expanded">{{ __('Read More') }}</span>
                                    <span x-show="expanded" style="display: none;">{{ __('Show Less') }}</span>
                                </button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </section>

        {{-- FAQ & Support Section --}}
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Kolom Kiri: FAQ --}}
                    <div x-data="{ open: 'faq-1' }">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('reviews.faq.title') }}</h2>
                        <div class="space-y-4">
                            {{-- FAQ 1 --}}
                            <div>
                                <button @click="open = (open === 'faq-1' ? '' : 'faq-1')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-white rounded-lg shadow-sm">
                                    <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item1.question') }}</span>
                                    <svg class="w-5 h-5 text-blue-500 transform transition-transform" :class="{'rotate-180': open === 'faq-1'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open === 'faq-1'" x-cloak x-transition class="mt-2 px-6 pb-4 text-gray-600">
                                    <p>{{ __('reviews.faq.item1.answer') }}</p>
                                </div>
                            </div>
                            {{-- FAQ 2 --}}
                            <div>
                                <button @click="open = (open === 'faq-2' ? '' : 'faq-2')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-white rounded-lg shadow-sm">
                                    <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item2.question') }}</span>
                                    <svg class="w-5 h-5 text-blue-500 transform transition-transform" :class="{'rotate-180': open === 'faq-2'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open === 'faq-2'" x-cloak x-transition class="mt-2 px-6 pb-4 text-gray-600">
                                    <p>{{ __('reviews.faq.item2.answer') }}</p>
                                </div>
                            </div>
                            {{-- FAQ 3 --}}
                            <div>
                                <button @click="open = (open === 'faq-3' ? '' : 'faq-3')" class="w-full flex justify-between items-center text-left py-4 px-6 bg-white rounded-lg shadow-sm">
                                    <span class="text-lg font-semibold text-gray-900">{{ __('reviews.faq.item3.question') }}</span>
                                    <svg class="w-5 h-5 text-blue-500 transform transition-transform" :class="{'rotate-180': open === 'faq-3'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open === 'faq-3'" x-cloak x-transition class="mt-2 px-6 pb-4 text-gray-600">
                                    <p>{{ __('reviews.faq.item3.answer') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Support --}}
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('reviews.support.title') }}</h2>
                        <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-yellow-400">
                            <p class="text-gray-600 mb-6">{{ __('reviews.support.description') }}</p>
                            <a href="https://wa.me/6281238455307?text=Hello%2C%2C%20I%20have%20a%20question%20about%20diving%20with%20Rumah%20Selam." target="_blank" rel="noopener noreferrer" class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md transition-transform transform hover:scale-105">
                                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.51 2 2 6.51 2 12.04c0 1.94.55 3.76 1.5 5.3L2 22l5.06-1.38c1.51.82 3.23 1.28 5.06 1.28C17.53 22 22 17.49 22 12.04S17.53 2 12.04 2zM17 15.65c-.21.08-.45.18-.72.26-.29.08-1.7-.63-1.99-.74-.29-.12-.51-.15-.72.15-.2.3-.85.74-1.04.85-.2.12-.4.15-.75.04-.3-.12-.66-.23-1.26-.59s-2.02-1.81-2.65-3.23c-.63-1.42-.07-2.18.42-2.67.43-.4.96-.98 1.15-1.28.19-.3.2-.56.09-.76-.09-.2-.29-.48-.4-.73-.12-.24-.26-.14-.52-.14-.26 0-.56-.04-.85-.04s-.68.11-.96.4C8.07 9.07 7.37 9.87 7.37 11.53c0 1.66 1.09 3.23 2.06 4.31.97 1.08 2.5 1.83 4.07 2.25 1.57.42 2.92.29 3.7-.22.78-.51 1.27-1.39 1.46-1.78.19-.38.19-.7-.08-.98z"/></svg>
                                {{ __('reviews.support.button') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-main-layout>