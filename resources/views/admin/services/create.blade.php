{{-- resources/views/admin/services/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Service') }}
        </h2>
    </x-slot>

    {{-- Script untuk CKEditor --}}
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Fungsi untuk menginisialisasi CKEditor
                function initializeEditor(element) {
                    ClassicEditor
                        .create(element)
                        .catch(error => {
                            console.error('Error creating CKEditor:', error);
                        });
                }

                // Inisialisasi editor yang terlihat saat load (EN)
                document.querySelectorAll('.ckeditor[data-locale="en"]').forEach(initializeEditor);

                // Tambahkan listener untuk inisialisasi editor saat tab diganti
                document.querySelectorAll('[data-tab-toggle]').forEach(tab => {
                    tab.addEventListener('click', function() {
                        const locale = this.getAttribute('data-tab-toggle');
                        const editors = document.querySelectorAll('.ckeditor[data-locale="' + locale + '"]');
                        
                        editors.forEach(editorEl => {
                            // Cek jika editor belum diinisialisasi
                            if (!editorEl.ckeditorInstance) {
                                ClassicEditor
                                    .create(editorEl)
                                    .then(editor => {
                                        editorEl.ckeditorInstance = editor; // Tandai sudah diinisialisasi
                                    })
                                    .catch(error => {
                                        console.error('Error creating CKEditor on tab switch:', error);
                                    });
                            }
                        });
                    }, { once: true }); // Hanya jalankan sekali per tab
                });
            });
        </script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- ========================================================== --}}
                    {{-- !! PERUBAHAN LAYOUT DIMULAI DI SINI !! --}}
                    {{-- ========================================================== --}}
                    
                    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. Tambahkan Alpine.js x-data untuk mengontrol tab --}}
                        <div x-data="{ tab: 'general' }">

                            {{-- 2. Buat Navigasi Tab --}}
                            <div class="border-b border-gray-200 mb-6">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    {{-- Tab untuk General --}}
                                    <button type="button" 
                                            @click="tab = 'general'"
                                            :class="{
                                                'border-indigo-500 text-indigo-600': tab === 'general',
                                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'general'
                                            }"
                                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        General
                                    </button>

                                    {{-- Loop Tab untuk Bahasa --}}
                                    @foreach(config('app.available_locales') as $locale => $localeName)
                                        <button type="button" 
                                                data-tab-toggle="{{ $locale }}" {{-- Untuk listener CKEditor --}}
                                                @click="tab = '{{ $locale }}'"
                                                :class="{
                                                    'border-indigo-500 text-indigo-600': tab === '{{ $locale }}',
                                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== '{{ $locale }}'
                                                }"
                                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            {{ $localeName }} ({{ strtoupper($locale) }})
                                        </button>
                                    @endforeach
                                </nav>
                            </div>

                            {{-- 3. Buat Panel Konten Tab --}}
                            
                            {{-- Panel "General" (Untuk Kategori & Gambar) --}}
                            <div x-show="tab === 'general'" class="space-y-6">
                                {{-- Dropdown Kategori Layanan --}}
                                <div>
                                    <x-input-label for="service_category_id" :value="__('Service Category')" />
                                    <select name="service_category_id" id="service_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_category_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Input Featured Image --}}
                                <div>
                                    <x-input-label for="featured_image" :value="__('Featured Image')" />
                                    <input type="file" name="featured_image" id="featured_image" class="block mt-1 w-full border border-gray-300 p-2 rounded-md shadow-sm">
                                    @error('featured_image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Panel per Bahasa (Loop) --}}
                            @foreach(config('app.available_locales') as $locale => $localeName)
                                <div x-show="tab === '{{ $locale }}'" class="space-y-6" style="display: none;">
                                    {{-- Input Judul --}}
                                    <div>
                                        <x-input-label :for="'title_' . $locale">
                                            {{ __('Title') }} ({{ strtoupper($locale) }}) 
                                            @if($locale === 'en') <span class="text-red-500">*</span> @endif
                                        </x-input-label>
                                        <x-text-input :id="'title_' . $locale" class="block mt-1 w-full" type="text" :name="'title[' . $locale . ']'" 
                                                      :value="old('title.' . $locale)" 
                                                      :required="$locale === 'en'" autofocus="{{ $locale === 'en' }}" />
                                        @error('title.' . $locale)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Input Deskripsi Singkat --}}
                                    <div>
                                        <x-input-label :for="'description_' . $locale">
                                            {{ __('Short Description') }} ({{ strtoupper($locale) }})
                                        </x-input-label>
                                        <textarea id="description_{{ $locale }}" name="description[{{ $locale }}]" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description.' . $locale) }}</textarea>
                                        @error('description.' . $locale)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Input Konten Lengkap --}}
                                    <div>
                                        <x-input-label :for="'content_' . $locale">
                                            {{ __('Full Content / Details') }} ({{ strtoupper($locale) }})
                                        </x-input-label>
                                        {{-- Tambahkan data-locale untuk listener JS --}}
                                        <textarea id="content_{{ $locale }}" name="content[{{ $locale }}]" rows="5" 
                                                  class="ckeditor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                  data-locale="{{ $locale }}">{{ old('content.' . $locale) }}</textarea>
                                        @error('content.' . $locale)
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            {{-- Tampilkan error umum untuk field translatable --}}
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol Submit (di luar div Alpine) --}}
                        <div class="flex items-center justify-end mt-6 border-t pt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Create Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                    
                    {{-- ========================================================== --}}
                    {{-- !! PERUBAHAN LAYOUT SELESAI !! --}}
                    {{-- ========================================================== --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>