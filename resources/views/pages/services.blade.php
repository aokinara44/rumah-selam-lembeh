<x-main-layout>
    {{-- Mengatur Judul dan Deskripsi secara dinamis --}}
    @section('title', isset($selectedCategory) ? $selectedCategory->name . ' - ' . __('Services') : __('Our Services') . ' - Rumah Selam Lembeh')
    @section('description', isset($selectedCategory) ? Str::limit(strip_tags($selectedCategory->services->first()?->description ?? __('Explore our services in the ') . $selectedCategory->name . __(' category.') ), 150) : __('Explore the variety of diving packages, land tours, and transportation services offered by Rumah Selam Lembeh Dive Center.'))

    {{-- Hero Section (Tetap Sama) --}}
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
        {{-- Fallback jika tidak ada gambar (Logika dari Anda) --}}
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            {{-- Menggunakan judul dinamis --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ isset($selectedCategory) ? $selectedCategory->name : __('services.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2 text-gray-200">{{ isset($selectedCategory) ? __('Showing services for category:') . ' ' . $selectedCategory->name : __('services.header.description') }}</p>
        </div>
    </section>

    {{-- Wrapper Konten dengan margin-top (Tetap Sama) --}}
    <div class="mt-[75vh] md:mt-[80vh]">
        {{-- Services Content --}}
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">

                {{-- Logika Percabangan --}}
                @if(isset($selectedCategory))
                    {{-- Kasus 1: Menampilkan HANYA Kategori yang Dipilih --}}
                    <div class="mb-16 animate-fade-in-up">
                        {{-- Judul kategori tidak perlu diulang jika hanya satu --}}
                        {{-- <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-yellow-400 pb-3">{{ $selectedCategory->name }}</h2> --}}

                        @if($selectedCategory->services->isNotEmpty())
                            <div class="space-y-8">
                                {{-- Loop hanya pada layanan dalam kategori ini --}}
                                @foreach($selectedCategory->services as $service)
                                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow duration-300 hover:shadow-2xl">
                                        <div class="md:flex">
                                            @if($service->featured_image)
                                                <div class="md:w-1/3 flex-shrink-0">
                                                    <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-56 md:h-full object-cover">
                                                </div>
                                            @else
                                                 <div class="md:w-1/3 flex-shrink-0 bg-gray-200 flex items-center justify-center text-gray-400 h-56 md:h-full">
                                                     <span>Image not available</span>
                                                 </div>
                                            @endif
                                            <div class="p-8 flex flex-col flex-grow">
                                                <h3 class="text-2xl font-bold text-blue-600 mb-3">{{ $service->title }}</h3>
                                                @if($service->description)
                                                    <div class="text-gray-600 mb-4 prose max-w-none">{!! $service->description !!}</div>
                                                @endif
                                                <div class="mt-auto pt-6 flex flex-wrap items-center gap-4">
                                                    @php
                                                        $whatsappText = urlencode("Hello, I am interested in the service: " . $service->getTranslation('title', 'en'));
                                                        $whatsappNumber = "6281238455307";
                                                    @endphp
                                                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappText }}"
                                                       target="_blank"
                                                       rel="noopener noreferrer"
                                                       class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-md hover:shadow-lg">
                                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.51 2 2 6.51 2 12.04c0 1.94.55 3.76 1.5 5.3L2 22l5.06-1.38c1.51.82 3.23 1.28 5.06 1.28C17.53 22 22 17.49 22 12.04S17.53 2 12.04 2zM17 15.65c-.21.08-.45.18-.72.26-.29.08-1.7-.63-1.99-.74-.29-.12-.51-.15-.72.15-.2.3-.85.74-1.04.85-.2.12-.4.15-.75.04-.3-.12-.66-.23-1.26-.59s-2.02-1.81-2.65-3.23c-.63-1.42-.07-2.18.42-2.67.43-.4.96-.98 1.15-1.28.19-.3.2-.56.09-.76-.09-.2-.29-.48-.4-.73-.12-.24-.26-.14-.52-.14-.26 0-.56-.04-.85-.04s-.68.11-.96.4C8.07 9.07 7.37 9.87 7.37 11.53c0 1.66 1.09 3.23 2.06 4.31.97 1.08 2.5 1.83 4.07 2.25 1.57.42 2.92.29 3.7-.22.78-.51 1.27-1.39 1.46-1.78.19-.38.19-.7-.08-.98z"/></svg>
                                                        {{ __('services.button.whatsapp') }}
                                                    </a>
                                                    @if($service->content)
                                                    <button @click="open = !open" class="inline-flex items-center justify-center text-gray-700 font-semibold hover:bg-gray-200 py-2 px-6 rounded-lg transition-colors border border-gray-300">
                                                        <span x-show="!open">{{ __('Read More') }}</span>
                                                        <span x-show="open" style="display: none;">{{ __('Show Less') }}</span>
                                                        <svg class="w-5 h-5 ml-2 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($service->content)
                                        <div x-show="open" style="display: none;"
                                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2">
                                            <div class="border-t border-gray-200 bg-gray-50 p-8">
                                                <div class="prose max-w-none text-gray-700">
                                                    {!! $service->content !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">{{ __('services.fallback.category') }}</p>
                        @endif
                    </div>
                @else
                    {{-- Kasus 2: Menampilkan SEMUA Kategori (Logika Lama) --}}
                    @if(!isset($serviceCategories) || $serviceCategories->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">{{ __('services.fallback.main') }}</p>
                        </div>
                    @else
                        @foreach($serviceCategories as $category)
                            <div class="mb-16 animate-fade-in-up">
                                <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-yellow-400 pb-3">{{ $category->name }}</h2>
                                @if($category->services->isNotEmpty())
                                    <div class="space-y-8">
                                        @foreach($category->services as $service)
                                            <div x-data="{ open: false }" class="bg-white rounded-xl shadow-lg overflow-hidden transition-shadow duration-300 hover:shadow-2xl">
                                                <div class="md:flex">
                                                     @if($service->featured_image)
                                                        <div class="md:w-1/3 flex-shrink-0">
                                                            <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-56 md:h-full object-cover">
                                                        </div>
                                                    @else
                                                         <div class="md:w-1/3 flex-shrink-0 bg-gray-200 flex items-center justify-center text-gray-400 h-56 md:h-full">
                                                             <span>Image not available</span>
                                                         </div>
                                                    @endif
                                                    <div class="p-8 flex flex-col flex-grow">
                                                        <h3 class="text-2xl font-bold text-blue-600 mb-3">{{ $service->title }}</h3>
                                                        @if($service->description)
                                                             <div class="text-gray-600 mb-4 prose max-w-none">{!! $service->description !!}</div>
                                                        @endif
                                                        <div class="mt-auto pt-6 flex flex-wrap items-center gap-4">
                                                            @php
                                                                $whatsappText = urlencode("Hello, I am interested in the service: " . $service->getTranslation('title', 'en'));
                                                                $whatsappNumber = "6281238455307";
                                                            @endphp
                                                            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappText }}"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-md hover:shadow-lg">
                                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.51 2 2 6.51 2 12.04c0 1.94.55 3.76 1.5 5.3L2 22l5.06-1.38c1.51.82 3.23 1.28 5.06 1.28C17.53 22 22 17.49 22 12.04S17.53 2 12.04 2zM17 15.65c-.21.08-.45.18-.72.26-.29.08-1.7-.63-1.99-.74-.29-.12-.51-.15-.72.15-.2.3-.85.74-1.04.85-.2.12-.4.15-.75.04-.3-.12-.66-.23-1.26-.59s-2.02-1.81-2.65-3.23c-.63-1.42-.07-2.18.42-2.67.43-.4.96-.98 1.15-1.28.19-.3.2-.56.09-.76-.09-.2-.29-.48-.4-.73-.12-.24-.26-.14-.52-.14-.26 0-.56-.04-.85-.04s-.68.11-.96.4C8.07 9.07 7.37 9.87 7.37 11.53c0 1.66 1.09 3.23 2.06 4.31.97 1.08 2.5 1.83 4.07 2.25 1.57.42 2.92.29 3.7-.22.78-.51 1.27-1.39 1.46-1.78.19-.38.19-.7-.08-.98z"/></svg>
                                                                {{ __('services.button.whatsapp') }}
                                                            </a>
                                                            @if($service->content)
                                                            <button @click="open = !open" class="inline-flex items-center justify-center text-gray-700 font-semibold hover:bg-gray-200 py-2 px-6 rounded-lg transition-colors border border-gray-300">
                                                                <span x-show="!open">{{ __('Read More') }}</span>
                                                                <span x-show="open" style="display: none;">{{ __('Show Less') }}</span>
                                                                <svg class="w-5 h-5 ml-2 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($service->content)
                                                <div x-show="open" style="display: none;"
                                                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2">
                                                    <div class="border-t border-gray-200 bg-gray-50 p-8">
                                                        <div class="prose max-w-none text-gray-700">
                                                            {!! $service->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 italic">{{ __('services.fallback.category') }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endif {{-- Akhir @if(isset($selectedCategory)) --}}

            </div>
        </section>
        {{-- AKHIR Services Content --}}
    </div> {{-- Penutup div wrapper margin-top --}}

</x-main-layout>
