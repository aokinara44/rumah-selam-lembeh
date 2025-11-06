{{-- Lokasi File: resources/views/welcome.blade.php --}}
<x-main-layout>

    {{-- 
      PERBAIKAN: Menghapus 'asset()' dari $heroImages[0]. 
      Variabel ini sudah berisi URL lengkap dari PageController.
    --}}
    @if(isset($heroImages) && !empty($heroImages[0]))
        @push('head')
            <link rel="preload" as="image" href="{{ $heroImages[0] }}" fetchpriority="high">
        @endpush
    @endif

    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <style>
            .swiper-pagination-bullet-active { background: #F59E0B !important; }
            .swiper-slide { display: flex; height: auto; }
            .swiper-slide > div { height: 100%; width: 100%; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
            .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        </style>
    @endpush

    <section
        x-data="{ images: {{ json_encode($heroImages ?? []) }}, current: 0, next() { this.current = (this.current + 1) % this.images.length; }, init() { if (this.images.length > 1) { setInterval(() => { this.next() }, 5000); } } }"
        x-init="init()"
        class="absolute inset-x-0 top-0 h-[75vh] md:h-[80vh] bg-cover bg-center text-white flex items-center justify-center overflow-hidden"
    >
        <template x-for="(image, index) in images" :key="index">
            <div
                class="absolute inset-0 bg-cover bg-center"
                {{-- 
                  PERBAIKAN: Menghapus '{{ asset('') }}' + 
                  Variabel 'image' sudah berisi URL lengkap dari PageController.
                --}}
                :style="'background-image: url(\'' + image + '\');'"
                x-show="current === index"
                x-transition:enter="transition-opacity ease-in-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in-out duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
        </template>
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://source.unsplash.com/1600x900/?scuba-diving,coral-reef');"></div>
        <div class="absolute inset-0 bg-black opacity-40"></div>
        
        <div class="relative z-10 text-center px-4 fade-in">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">{{ __('hero.title') }}</h1>
            <p class="text-base md:text-xl max-w-3xl mx-auto mb-8" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">{{ __('hero.description') }}</p>
            <a href="https://wa.me/6281238455307?text=Hello%2C%20I%20would%20like%20to%20ask%20about%20availability%20and%20prices%20for%20diving." target="_blank" rel="noopener noreferrer" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:scale-105 text-base md:text-lg inline-block mb-12">{{ __('hero.button') }}</a>
        </div>
    </section>

    <div class="mt-[75vh] md:mt-[80vh]">
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-12 text-gray-800">{{ __('usp.title') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="fade-in" style="animation-delay: 0.2s;">
                        <div class="bg-blue-500 text-white w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <h3 class="text-xl font-semibold mb-2">{{ __('usp.item1.title') }}</h3>
                        <p class="text-gray-600">{{ __('usp.item1.description') }}</p>
                    </div>
                    <div class="fade-in" style="animation-delay: 0.4s;">
                        <div class="bg-yellow-400 text-gray-800 w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <h3 class="text-xl font-semibold mb-2">{{ __('usp.item2.title') }}</h3>
                        <p class="text-gray-600">{{ __('usp.item2.description') }}</p>
                    </div>
                    <div class="fade-in" style="animation-delay: 0.6s;">
                        <div class="bg-blue-500 text-white w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                        <h3 class="text-xl font-semibold mb-2">{{ __('usp.item3.title') }}</h3>
                        <p class="text-gray-600">{{ __('usp.item3.description') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('services.popular.title') }}</h2>
                    <p class="text-gray-600 mt-2">{{ __('services.popular.description') }}</p>
                </div>
                @if(isset($featuredServices) && $featuredServices->isNotEmpty())
                    <div class="swiper service-swiper relative pb-16">
                        <div class="swiper-wrapper">
                            @foreach($featuredServices as $service)
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 fade-in h-full flex flex-col">
                                        <img src="{{ $service->featured_image ? Storage::url($service->featured_image) : 'https://source.unsplash.com/400x300/?diving,ocean' }}"
                                            alt="{{ $service->getTranslation('title', app()->getLocale(), false) }}"
                                            class="w-full h-56 object-cover" loading="lazy" decoding="async" width="400" height="300">
                                        <div class="p-6 flex-grow">
                                            <span class="text-sm text-blue-500 font-semibold">
                                                {{ $service->serviceCategory ? $service->serviceCategory->getTranslation('name', app()->getLocale(), false) : __('Uncategorized') }}
                                            </span>
                                            <h3 class="text-xl font-bold my-2">
                                                {{ $service->getTranslation('title', app()->getLocale(), false) }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-4">
                                                {{ Str::limit($service->getTranslation('description', app()->getLocale(), false), 100) }}
                                            </p>
                                        </div>
                                        <div class="p-6 pt-0">
                                            {{-- 
                                              PERBAIKAN: Link kini mengarah ke 'services.category' jika kategori ada. 
                                              Jika tidak, kembali ke 'services' (fallback).
                                            --}}
                                            <a href="{{ $service->serviceCategory ? route('services.category', ['locale' => app()->getLocale(), 'categorySlug' => $service->serviceCategory->slug]) : route('services', ['locale' => app()->getLocale()]) }}" 
                                               class="font-semibold text-yellow-500 hover:text-yellow-600">{{ __('Learn More') }} &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination service-pagination !absolute bottom-6"></div>
                    </div>
                @else
                    <p class="text-center text-gray-500">{{ __('services.popular.fallback') }}</p>
                @endif
                <div class="text-center mt-12">
                    <a href="{{ route('services', ['locale' => app()->getLocale()]) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:scale-105">{{ __('View All Services') }}</a>
                </div>
            </div>
        </section>

        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('safety.title') }}</h2>
                    <p class="text-gray-600 mt-2">{{ __('safety.description') }}</p>
                </div>
                <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 p-6 md:p-8 rounded-lg shadow-md border-l-4 border-yellow-400 fade-in" style="animation-delay: 0.3s;">
                        <h3 class="text-xl font-semibold mb-3">{{ __('safety.item1.title') }}</h3>
                        <p class="text-gray-600">{{ __('safety.item1.description') }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 md:p-8 rounded-lg shadow-md border-l-4 border-blue-500 fade-in" style="animation-delay: 0.6s;">
                        <h3 class="text-xl font-semibold mb-3">{{ __('safety.item2.title') }}</h3>
                        <p class="text-gray-600">{{ __('safety.item2.description') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- PERUBAHAN 1: Menambahkan ID "reviews" dan offset scroll --}}
        <section id="reviews" class="py-16 bg-gray-50 scroll-mt-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ __('reviews.latest.title') }}</h2>
                    <p class="text-gray-600 mt-2">{{ __('reviews.latest.description') }}</p>
                </div>
                
                {{-- PERUBAHAN 2: Menggunakan $allReviews (bukan $latestReviews) --}}
                @if(isset($allReviews) && $allReviews->isNotEmpty())
                    <div class="swiper review-swiper relative pb-16">
                        <div class="swiper-wrapper">
                            @foreach($allReviews as $review)
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between transform hover:-translate-y-2 transition-transform duration-300 fade-in h-full">
                                        <div>
                                            @if(isset($review->rating))
                                                <div class="flex items-center mb-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.445a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.538 1.118l-3.367-2.445a1 1 0 00-1.175 0l-3.367 2.445c-.783.57-1.838-.197-1.538-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" /></svg>
                                                    @endfor
                                                </div>
                                            @endif
                                            <p class="text-gray-600 italic mb-4">
                                                "{{ Str::limit($review->getTranslation('review_text', app()->getLocale(), false), 150) }}"
                                            </p>
                                        </div>
                                        <div class="flex items-center mt-4 pt-4 border-t border-gray-100">
                                            
                                            {{-- PERUBAHAN 3: Mengganti SVG placeholder dengan Foto --}}
                                            <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ $review->photo_url }}" alt="{{ $review->getTranslation('reviewer_name', app()->getLocale(), false) }}">
                                            
                                            <div>
                                                <p class="font-semibold text-gray-800">
                                                    {{ $review->getTranslation('reviewer_name', app()->getLocale(), false) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination review-pagination !absolute bottom-6"></div>
                    </div>
                @else
                    <div class="text-center text-gray-500"><p>{{ __('reviews.latest.fallback') }}</p></div>
                @endif
                
                {{-- PERUBAHAN 4: Menghapus tombol "Read All Reviews" --}}
                {{-- 
                <div class="text-center mt-12">
                    <a href="{{ route('reviews', ['locale' => app()->getLocale()]) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:scale-105">{{ __('Read All Reviews') }}</a>
                </div> 
                --}}
            </div>
        </section>
    </div> {{-- Penutup div margin-top --}}

    @push('scripts')
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var serviceSwiper = new Swiper('.service-swiper', {
                    loop: {{ isset($featuredServices) && $featuredServices->count() > 3 ? 'true' : 'false' }},
                    slidesPerView: 1,
                    spaceBetween: 32,
                    autoplay: { delay: 4000, disableOnInteraction: false },
                    pagination: { el: '.service-pagination', clickable: true },
                    breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
                });
                
                {{-- PERUBAHAN 5: Menggunakan $allReviews untuk logika loop Swiper --}}
                var reviewSwiper = new Swiper('.review-swiper', {
                    loop: {{ isset($allReviews) && $allReviews->count() > 3 ? 'true' : 'false' }},
                    slidesPerView: 1,
                    spaceBetween: 32,
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    pagination: { el: '.review-pagination', clickable: true },
                    breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
                });
            });
        </script>
    @endpush

</x-main-layout>