{{-- resources/views/pages/explore/diving.blade.php --}}

<x-main-layout :title="__('explore.lembeh.title')">

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
        {{-- Fallback jika tidak ada gambar --}}
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            
            {{-- Judul dan deskripsi disesuaikan untuk Lembeh Diving --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ isset($selectedCategory) ? $selectedCategory->name : __('explore.lembeh.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2 text-gray-200">{{ isset($selectedCategory) ? __('explore.common.category_prefix') . ' ' . $selectedCategory->name : __('explore.lembeh.header.description') }}</p>

        </div>
    </section>

    {{-- ========================================================== --}}
    {{-- START KONTEN ARTIKEL YANG DI-LOAD DARI JSON --}}
    {{-- ========================================================== --}}
    
    <div class="mt-[75vh] md:mt-[80vh]">
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">

                <div class="max-w-4xl mx-auto">

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 1: PENGANTAR --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h1') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p1') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p2') }}
                    </p>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h2_1') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p3') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {!! __('explore.lembeh.article.p4') !!} {{-- Menggunakan {!! !!} untuk render <strong> --}}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 2: GEOGRAFI & PETA --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_2') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p5') }}
                    </p>
                    
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_1') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p6') }}
                    </p>
                    
                    {{-- PETA YANG DISEMATKAN --}}
                    <div class="my-6 rounded-lg shadow-md overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/d/embed?mid=1LM899nZl_RiWG0rh6399utb_zFA7HNI&ehbc=2E312F" 
                            class="w-full aspect-video border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                     <p class="text-sm text-center text-gray-600 -mt-4 mb-6 italic">{{ __('explore.lembeh.article.map_note') }}</p>
                    

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_2') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p7') }}
                    </p>
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_3') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p8') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- GAMBAR 1 --}}
                    {{-- ========================================================== --}}
                    <figure class="my-6">
                        <img src="{{ asset('images/hero/Coconut octopus (1).webp') }}" alt="Coconut Octopus in Lembeh Strait" class="rounded-lg shadow-md w-full">
                        <figcaption class="text-sm text-center text-gray-600 mt-2 italic">{{ __('explore.lembeh.article.img1_caption') }}</figcaption>
                    </figure>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 3: "WONDERS THAT AWAIT" --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_3') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p9') }}
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list1.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li2') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li3') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li4') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li5') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li6') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li7') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li8') !!}</li>
                        <li>{!! __('explore.lembeh.article.list1.li9') !!}</li>
                    </ul>

                    {{-- ========================================================== --}}
                    {{-- GAMBAR 2 & 3 --}}
                    {{-- ========================================================== --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-8">
                        <figure>
                            <img src="{{ asset('images/hero/Bullocky Nudibranch  (1).webp') }}" alt="Bullocky Nudibranch in Lembeh Strait" class="rounded-lg shadow-md w-full">
                            <figcaption class="text-center text-sm italic text-gray-600 mt-2">{{ __('explore.lembeh.article.img2_caption') }}</figcaption>
                        </figure>
                        <figure>
                            <img src="{{ asset('images/hero/weedy scorpion fish (Rhinophias) (1).webp') }}" alt="Weedy Scorpionfish (Rhinopias) in Lembeh Strait" class="rounded-lg shadow-md w-full">
                            <figcaption class="text-center text-sm italic text-gray-600 mt-2">{{ __('explore.lembeh.article.img3_caption') }}</figcaption>
                        </figure>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 4: PENGALAMAN MENYELAM --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_4') }}</h2>
                    
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_4') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p10') }}
                    </p>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_5') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p11') }}
                    </p>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_6') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p12') }}
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list2.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list2.li2') !!}</li>
                        <li>{!! __('explore.lembeh.article.list2.li3') !!}</li>
                    </ul>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_7') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p13') }}
                    </p>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 5: FOTOGRAFI --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_5') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p14') }}
                    </p>
                    
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_8') }}</h3>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list3.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list3.li2') !!}</li>
                        <li>{!! __('explore.lembeh.article.list3.li3') !!}</li>
                        <li>{!! __('explore.lembeh.article.list3.li4') !!}</li>
                    </ul>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_9') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {!! __('explore.lembeh.article.p15') !!}
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list4.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list4.li2') !!}</li>
                        <li>{!! __('explore.lembeh.article.list4.li3') !!}</li>
                        <li>{!! __('explore.lembeh.article.list4.li4') !!}</li>
                    </ul>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 6: PERENCANAAN --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_6') }}</h2>
                    
                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_10') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {!! __('explore.lembeh.article.p16') !!}
                    </p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list5.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list5.li2') !!}</li>
                    </ul>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_11') }}</h3>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {!! __('explore.lembeh.article.p17') !!}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p18') }}
                    </p>

                    <h3 class="text-2xl font-semibold mt-6 mb-3 text-gray-900">{{ __('explore.lembeh.article.h3_12') }}</h3>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4 space-y-2 pl-4">
                        <li>{!! __('explore.lembeh.article.list6.li1') !!}</li>
                        <li>{!! __('explore.lembeh.article.list6.li2') !!}</li>
                        <li>{!! __('explore.lembeh.article.list6.li3') !!}</li>
                        <li>{!! __('explore.lembeh.article.list6.li4') !!}</li>
                    </ul>

                    {{-- ========================================================== --}}
                    {{-- BAGIAN 7: "WHY DIVE WITH US" --}}
                    {{-- ========================================================== --}}
                    <h2 class="text-3xl font-bold mt-8 mb-4 text-gray-900">{{ __('explore.lembeh.article.h2_7') }}</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p19') }}
                    </p>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        {{ __('explore.lembeh.article.p20') }}
                    </p>
                    
                    {{-- ========================================================== --}}
                    {{-- Call to Action --}}
                    {{-- ========================================================== --}}
                    <div class="mt-12 bg-blue-50 dark:bg-gray-800 p-6 rounded-lg border-l-4 border-blue-500">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            {{ __('explore.common.cta.title') }}
                        </h4>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ __('explore.lembeh.article.cta.description') }}
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
    {{-- AKHIR PERUBAHAN KONTEN --}}
    {{-- ========================================================== --}}
</x-main-layout>