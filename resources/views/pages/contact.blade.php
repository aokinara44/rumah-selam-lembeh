{{-- Lokasi File: resources/views/pages/contact.blade.php --}}

<x-main-layout>
    @section('title', 'Contact Us - Rumah Selam Lembeh')
    @section('description', 'Get in touch with Rumah Selam Lembeh. Contact us for bookings, inquiries, or any questions you have about diving in Lembeh Strait.')

    {{-- ========================================================== --}}
    {{-- HERO SECTION - TIDAK DIUBAH --}}
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
        {{-- Fallback jika tidak ada gambar (Logika dari Anda) --}}
        <div x-show="images.length === 0" class="absolute inset-0 bg-gray-600" style="background-image: url('https://placehold.co/1600x900/003366/FFFFFF?text=Rumah+Selam+Lembeh');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
        {{-- Konten header (Judul & Deskripsi) --}}
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            {{-- Menggunakan key JSON dari halaman kontak --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ __('contact.header.title') }}</h1>
            <p class="text-lg md:text-xl mt-2 text-gray-200">{{ __('contact.header.description') }}</p>
        </div>
    </section>
    {{-- !! AKHIR HERO SECTION !! --}}


    {{-- ========================================================== --}}
    {{-- DIV WRAPPER MARGIN TOP - TIDAK DIUBAH --}}
    {{-- ========================================================== --}}
    <div class="mt-[75vh] md:mt-[80vh]">

        {{-- Contact Form & Info (Konten Asli Anda Mulai Dari Sini) --}}
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    {{-- ========================================================== --}}
                    {{-- FORM KONTAK (KOLOM KANAN) - TIDAK DIUBAH --}}
                    {{-- ========================================================== --}}
                    <div class="fade-in">
                        <h2 class="text-3xl font-bold mb-6 text-gray-800">{{ __('contact.form.title') }}</h2>
                        
                        {{-- Session Message --}}
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if(session('error'))
                             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                 <span class="block sm:inline">{{ session('error') }}</span>
                             </div>
                        @endif

                        {{-- Form (sudah benar dengan locale) --}}
                        <form action="{{ route('contact.submit', ['locale' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    {{-- Menggunakan key JSON --}}
                                    <label for="name" class="block text-gray-700 font-medium mb-2">{{ __('contact.form.name') }}</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ __('contact.form.name.placeholder') }}" required>
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    {{-- Menggunakan key JSON --}}
                                    <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('contact.form.email') }}</label>
                                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ __('contact.form.email.placeholder') }}" required>
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                 {{-- Menggunakan key JSON --}}
                                <label for="subject" class="block text-gray-700 font-medium mb-2">{{ __('contact.form.subject') }}</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ __('contact.form.subject.placeholder') }}" required>
                                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                 {{-- Menggunakan key JSON --}}
                                <label for="message" class="block text-gray-700 font-medium mb-2">{{ __('contact.form.message') }}</label>
                                <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ __('contact.form.message.placeholder') }}" required></textarea>
                                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <button type="submit" class="bg-yellow-400 text-gray-800 px-8 py-3 rounded-full font-semibold hover:bg-yellow-500 transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                                    {{-- Menggunakan key JSON --}}
                                    {{ __('contact.form.button') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- START PERUBAHAN DI SINI (KOLOM KIRI) --}}
                    {{-- ========================================================== --}}
                    <div class="fade-in" style="animation-delay: 0.2s;">
                         <h2 class="text-3xl font-bold mb-6 text-gray-800">{{ __('contact.info.title') }}</h2>
                        <p class="text-gray-600 mb-6">{{ __('contact.info.description') }}</p>
                        
                        {{-- Menggunakan struktur <div class="space-y-6"> yang asli --}}
                        <div class="space-y-6">
                            
                            {{-- Phone (DINAMIS) --}}
                            @if(isset($siteContacts['phone']) && $siteContacts['phone']->isNotEmpty())
                                @foreach($siteContacts['phone'] as $contact)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></span></div>
                                    <div class="ml-4">
                                         <h3 class="text-lg font-semibold text-gray-800">{{ $contact->name }}</h3>
                                         <p class="text-gray-600">{{ __('contact.info.item1.description') }}</p>
                                         <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->value) }}" target="_blank" class="text-blue-600 hover:text-yellow-500 font-medium transition">{{ $contact->value }}</a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            
                            {{-- Email (DINAMIS) --}}
                            @if(isset($siteContacts['email']) && $siteContacts['email']->isNotEmpty())
                                @foreach($siteContacts['email'] as $contact)
                                <div class="flex items-start">
                                     <div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span></div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $contact->name }}</h3>
                                        <p class="text-gray-600">{{ __('contact.info.item2.description') }}</p>
                                        <a href="mailto:{{ $contact->value }}" class="text-blue-600 hover:text-yellow-500 font-medium transition">{{ $contact->value }}</a>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            {{-- Alamat (DINAMIS - BLOK BARU) --}}
                            @if(isset($siteContacts['address']) && $siteContacts['address']->isNotEmpty())
                                @foreach($siteContacts['address'] as $contact)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg></span></div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $contact->name }}</h3>
                                        {{-- Link ke Google Maps bisa Anda masukkan di 'value' di admin jika mau --}}
                                        <a href="http://googleusercontent.com/maps/google.com/2{{ urlencode($contact->value) }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-yellow-500 transition">
                                            {!! nl2br(e($contact->value)) !!}
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            {{-- Social Media & QR Code (DINAMIS) --}}
                            <div class="flex items-start">
                                 <div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.102 1.101"></path></svg></span></div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ __('contact.info.item3.title') }}</h3>
                                    <p class="text-gray-600">{{ __("contact.info.item3.description") }}</p>
                                    
                                    {{-- Ikon Sosial Media --}}
                                    @if(isset($siteContacts['social']) && $siteContacts['social']->isNotEmpty())
                                    <div class="flex space-x-4 mt-2">
                                        @foreach($siteContacts['social'] as $social)
                                            <a href="{{ $social->value }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-blue-600 transition duration-300" aria-label="Follow us on {{ $social->name }}">
                                                @if($social->icon_svg)
                                                    {!! $social->icon_svg !!}
                                                @else
                                                    {{-- Fallback jika tidak ada SVG --}}
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.5 0-2 2-2h2V2h-4c-4 0-5 3-5 5v2H7.5v4H10v7h4v-7z" /></svg>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- QR Codes --}}
                                    @if(isset($siteContacts['qr_code']) && $siteContacts['qr_code']->isNotEmpty())
                                    <div class="mt-4 flex flex-wrap gap-4">
                                        @foreach($siteContacts['qr_code'] as $qr)
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $qr->name }}</p>
                                            <img src="{{ asset($qr->value) }}" alt="{{ $qr->name }} QR Code" class="w-24 h-24 mt-1 rounded-md bg-white p-1 border">
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ========================================================== --}}
                    {{-- AKHIR PERUBAHAN --}}
                    {{-- ========================================================== --}}

                </div>
            </div>
        </section>

    </div> {{-- Penutup div margin-top --}}
    {{-- !! AKHIR PERUBAHAN MARGIN TOP !! --}}

</x-main-layout>