{{-- resources/views/pages/explore/tangkoko.blade.php --}}

<x-main-layout :title="__('explore.tangkoko.title')">

    {{-- ========================================================== --}}
    {{-- HERO SECTION - STRUKTUR SAMA, KONTEN DISESUAIKAN --}}
    {{-- ========================================================== --}}
    <section
        x-data="{ images: {{ json_encode($heroImages ?? []) }}, current: 0, next() { this.current = (this.current + 1) % this.images.length; }, init() { if (this.images.length > 1) { setInterval(() => { this.next() }, 5000); } } }"
        x-init="init()"
        class="absolute inset-x-0 top-0 h-[75vh] md:h-[80vh] bg-cover bg-center text-white flex items-center justify-center overflow-hidden"
    >
        <template x-for="(image, index) in images" :key="index">
            {{-- Menggunakan asset() untuk URL gambar --}}
            <div
                class="absolute inset-0 bg-cover bg-center"
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
        {{-- Fallback jika tidak ada gambar (Teks diubah untuk Tangkoko) --}}
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Tangkoko+National+Park');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            
            {{-- Judul dan deskripsi disesuaikan untuk Tangkoko --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ isset($selectedCategory) ? $selectedCategory->name : __('explore.tangkoko.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2 text-gray-200">{{ isset($selectedCategory) ? __('explore.common.category_prefix') . ' ' . $selectedCategory->name : __('explore.tangkoko.header.description') }}</p>

        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- START KONTEN ARTIKEL TANGKOKO --}}
    {{-- ========================================================== --}}
    
    <div class="mt-[75vh] md:mt-[80vh]">
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">

                <div class="max-w-4xl mx-auto">

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 1: PENGANTAR TANGKOKO --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.tangkoko.article.h1') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p1') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p2') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p3') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 2: SUASANA HUTAN --}}
                    {{-- ========================================================== --}}
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h2_1') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p4') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p5') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p6') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 3: PRIMATA (YAKI) --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.tangkoko.article.h2_2') }}</h2>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_1') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p7') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p8') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p9') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p10') }}
                    </p>

                    {{-- GAMBAR 1 (YAKI) --}}
                    <figure class="my-6">
                        <img src="https://www.lembehresort.com/wp-content/uploads/Black-crested-macaque.jpg" alt="Black Crested Macaque (Yaki) in Tangkoko" class="rounded-lg shadow-md w-full">
                        <figcaption class="text-sm text-center text-gray-600 mt-2 italic">{{ __('explore.tangkoko.article.img1_caption') }}</figcaption>
                    </figure>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 4: PRIMATA (TARSIUS) --}}
                    {{-- ========================================================== --}}
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_2') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p11') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p12') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p13') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p14') }}
                    </p>

                    {{-- GAMBAR 2 & 3 (TARSIUS & RANGKONG) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-8">
                        <figure>
                            <img src="https://www.lembehresort.com/wp-content/uploads/Lembeh-Resort-Tarsier-9-copy.jpg?lossy=2&strip=0&webp=1" alt="Spectral Tarsier in Tangkoko" class="rounded-lg shadow-md w-full object-cover h-full">
                            <figcaption class="text-center text-sm italic text-gray-600 mt-2">{{ __('explore.tangkoko.article.img2_caption') }}</figcaption>
                        </figure>
                        <figure>
                            <img src="https://images.unsplash.com/photo-1702945262371-50629a54a27e?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%D&auto=format&fit=crop&q=80&w=435" alt="Knobbed Hornbill in Tangkoko" class="rounded-lg shadow-md w-full object-cover h-full">
                            <figcaption class="text-center text-sm italic text-gray-600 mt-2">{{ __('explore.tangkoko.article.img3_caption') }}</figcaption>
                        </figure>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 5: EKOSISTEM LAIN & PEMANDU --}}
                    {{-- ========================================================== --}}
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_3') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p15') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p16') }}
                    </p>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_4') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p17') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p18') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 6: WAKTU KUNJUNGAN --}}
                    {{-- ========================================================== --}}
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_5') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p19') }}
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.tangkoko.article.list1.li1') !!}</li>
                        <li>{!! __('explore.tangkoko.article.list1.li2') !!}</li>
                    </ul>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.tangkoko.article.h3_6') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.tangkoko.article.p20') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- Call to Action (Disesuaikan untuk Tangkoko) --}}
                    {{-- ========================================================== --}}
                    <div class="mt-12 bg-blue-50 dark:bg-gray-800 p-6 rounded-lg border-l-4 border-blue-500">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            {{ __('explore.tangkoko.article.cta.title') }}
                        </h4>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ __('explore.tangkoko.article.cta.description') }}
                        </p>
                        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-block bg-yellow-400 text-gray-800 px-6 py-2 rounded-full font-semibold hover:bg-yellow-500 transition duration-300 ease-in-out shadow-md hover:shadow-lg mt-4">
                            {{ __('explore.common.cta.button') }}
                        </a>
                    </div>
                    
                </div>
                
            </div>
        </section>
    </div>
    {{-- ========================================================== --}}
    {{-- AKHIR KONTEN ARTIKEL TANGKOKO --}}
    {{-- ========================================================== --}}
</x-main-layout>