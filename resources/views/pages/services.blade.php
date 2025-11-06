{{-- resources/views/pages/services.blade.php --}}
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
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam Lembeh');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            {{-- Menggunakan judul dinamis --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ isset($selectedCategory) ? $selectedCategory->name : __('services.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2 text-gray-200">{{ isset($selectedCategory) ? __('Showing services for category:') . ' ' . $selectedCategory->name : __('services.header.description') }}</p>
        </div>
    </section>

    {{-- Wrapper Konten dengan margin-top (Tetap Sama) --}}
    <div class="mt-[75vh] md:mt-[80vh]">
        
        {{-- Wrapper ini sekarang mengontrol state modal (pop-up) --}}
        <section class="py-20 bg-gray-50" x-data="{ modalOpen: false, selectedService: null }">
            <div class="container mx-auto px-6">

                @php
                    // ** LOGIKA REFACTOR (Tetap Sama) **
                    $categoriesToShow = isset($selectedCategory) ? collect([$selectedCategory]) : ($serviceCategories ?? collect([]));
                @endphp

                @if($categoriesToShow->isEmpty())
                    {{-- Fallback jika tidak ada kategori sama sekali --}}
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('services.fallback.main') }}</p>
                    </div>
                @else
                    {{-- ** SATU LOOP UTAMA (Tetap Sama) ** --}}
                    <div class="space-y-16">
                        @foreach($categoriesToShow as $category)
                            <div class="animate-fade-in-up">
                                
                                {{-- Judul Kategori (Tetap Sama) --}}
                                @if(!isset($selectedCategory))
                                    <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-yellow-400 pb-3">{{ $category->name }}</h2>
                                @endif

                                @if($category->services->isNotEmpty())
                                    
                                    {{-- Layout Grid 2 Kolom --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        
                                        {{-- Loop untuk setiap service di dalam kategori --}}
                                        @foreach($category->services as $service)
                                            
                                            {{-- ========================================================== --}}
                                            {{-- !! PERUBAHAN DI SINI !! --}}
                                            {{-- Menyiapkan data lengkap untuk dikirim ke modal (pop-up) --}}
                                            {{-- ========================================================== --}}
                                            @php
                                                $modalData = $service->only(['title', 'description', 'content']);
                                                // Kita buat URL gambar di sini agar tidak perlu logika di JS
                                                $modalData['image_url'] = $service->featured_image ? Storage::url($service->featured_image) : null;
                                            @endphp


                                            {{-- =================================== --}}
                                            {{-- START: Service Card (Vertikal) --}}
                                            {{-- =================================== --}}
                                            
                                            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl flex flex-col group h-full">
                                                
                                                {{-- Gambar --}}
                                                <div class="flex-shrink-0 h-56 overflow-hidden">
                                                    @if($service->featured_image)
                                                        <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->title }}" 
                                                             class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                                                    @else
                                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                            <span>Image not available</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Konten Teks --}}
                                                <div class="p-6 flex flex-col flex-grow">
                                                    <h3 class="text-2xl font-bold text-blue-600 mb-3">{{ $service->title }}</h3>
                                                    
                                                    @if($service->description)
                                                        <div class="text-gray-600 mb-4 prose max-w-none">
                                                            {!! $service->description !!}
                                                        </div>
                                                    @endif

                                                    {{-- Tombol (di bawah) --}}
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
                                                            {{-- ========================================================== --}}
                                                            {{-- !! PERUBAHAN DI SINI !! --}}
                                                            {{-- Menggunakan variabel $modalData yang baru --}}
                                                            {{-- ========================================================== --}}
                                                            <button 
                                                                data-service="{{ json_encode($modalData) }}"
                                                                @click="selectedService = JSON.parse($event.currentTarget.dataset.service); modalOpen = true"
                                                                class="inline-flex items-center justify-center text-gray-700 font-semibold hover:bg-gray-200 py-2 px-6 rounded-lg transition-colors border border-gray-300">
                                                                <span>{{ __('Read More') }}</span>
                                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- =================================== --}}
                                            {{-- END: Service Card --}}
                                            {{-- =================================== --}}

                                        @endforeach {{-- End loop service --}}
                                    </div>
                                @else
                                    {{-- Fallback jika kategori ada tapi tidak punya service --}}
                                    <p class="text-gray-500 italic">{{ __('services.fallback.category') }}</p>
                                @endif
                            </div>
                        @endforeach {{-- End loop kategori --}}
                    </div>
                @endif {{-- End Cek $categoriesToShow->isEmpty() --}}

            </div> {{-- End container --}}

            {{-- =================================== --}}
            {{-- START: Modal (Pop-up) --}}
            {{-- =================================== --}}
            <div 
                x-show="modalOpen" 
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8"
                style="display: none;">
                
                {{-- Overlay gelap di belakang --}}
                <div class="fixed inset-0 bg-black/75" @click="modalOpen = false; selectedService = null" aria-hidden="true"></div>

                {{-- Panel Konten Modal --}}
                <div 
                    x-show="modalOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.away="modalOpen = false; selectedService = null"
                    class="relative bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col"
                >
                    {{-- Header Modal (Menampilkan Judul) --}}
                    <div class="flex items-center justify-between p-4 md:p-6 border-b flex-shrink-0">
                        <h3 class="text-2xl font-bold text-blue-600" x-text="selectedService ? selectedService.title : ''"></h3>
                        <button @click="modalOpen = false; selectedService = null" class="text-gray-400 hover:text-gray-600" aria-label="Close modal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- !! PERUBAHAN DI SINI !! --}}
                    {{-- Body Modal (Scrollable) sekarang berisi gambar, deskripsi, dan konten --}}
                    {{-- ========================================================== --}}
                    <div class="overflow-y-auto">
                        
                        {{-- 1. Gambar (jika ada) --}}
                        <div x-show="selectedService" class="w-full">
                            {{-- Template untuk gambar yang ada --}}
                            <template x-if="selectedService.image_url">
                                <img :src="selectedService.image_url" :alt="selectedService.title" 
                                     class="w-full h-56 md:h-72 object-cover">
                            </template>
                            {{-- Template fallback jika gambar tidak ada --}}
                            <template x-if="!selectedService.image_url">
                                 <div class="h-56 md:h-72 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                     <span>Image not available</span>
                                 </div>
                            </template>
                        </div>
                        
                        {{-- Wrapper untuk konten teks (agar bisa di-padding) --}}
                        <div class="p-4 md:p-6">
                            {{-- 2. Deskripsi Singkat (jika ada) --}}
                            <div x-show="selectedService && selectedService.description" 
                                 class="text-gray-600 mb-4 prose max-w-none"
                                 x-html="selectedService.description">
                                 {{-- Konten $service->description akan dirender di sini --}}
                            </div>

                            {{-- 3. Garis Pemisah (jika ada deskripsi DAN konten) --}}
                            <hr x-show="selectedService && selectedService.description && selectedService.content" class="my-6">

                            {{-- 4. Konten Lengkap (jika ada) --}}
                            <div x-show="selectedService && selectedService.content" 
                                 class="prose max-w-none" 
                                 x-html="selectedService.content">
                                 {{-- Konten $service->content akan dirender di sini --}}
                            </div>
                        </div>
                        
                    </div>

                    {{-- Footer Modal (Tombol Close) --}}
                    <div class="p-4 md:p-6 border-t bg-gray-50 text-right rounded-b-lg flex-shrink-0">
                        <button @click="modalOpen = false; selectedService = null" class="text-gray-700 font-semibold hover:bg-gray-200 py-2 px-6 rounded-lg transition-colors border border-gray-300">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
            {{-- =================================== --}}
            {{-- END: Modal (Pop-up) --}}
            {{-- =================================== --}}

        </section>

    </div> {{-- Penutup div wrapper margin-top --}}

</x-main-layout>