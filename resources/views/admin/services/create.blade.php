{{-- resources/views/admin/services/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Service') }}
        </h2>
    </x-slot>

    {{-- !! PERUBAHAN: Pindahkan Pemuatan CKEditor ke Head !! --}}
    @push('head')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    @endpush

    {{-- Script Inisialisasi CKEditor (Tetap di Akhir Body) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.ckeditor').forEach(function(element) {
                    ClassicEditor
                        .create(element)
                        .catch(error => {
                            console.error('CKEditor Error:', error);
                        });
                });
            });
        </script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Dropdown Kategori Layanan --}}
                        <div class="mb-4">
                            <x-input-label for="service_category_id" :value="__('Service Category')" />
                            <select name="service_category_id" id="service_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @isset($categories)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} 
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('service_category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Loop untuk Input Judul per Bahasa --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'title_' . $locale">
                                    {{ __('Title') }} ({{ strtoupper($locale) }}) 
                                    @if($locale === 'en') <span class="text-red-500">*</span> @endif
                                </x-input-label>
                                <x-text-input :id="'title_' . $locale" class="block mt-1 w-full" type="text" :name="'title[' . $locale . ']'" :value="old('title.' . $locale)" :required="$locale === 'en'" autofocus="{{ $locale === 'en' }}" />
                                @error('title.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                         {{-- Loop untuk Input Deskripsi Singkat per Bahasa (Textarea) --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'description_' . $locale">
                                    {{ __('Short Description') }} ({{ strtoupper($locale) }}) 
                                </x-input-label>
                                <textarea id="description_{{ $locale }}" name="description[{{ $locale }}]" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description.' . $locale) }}</textarea>
                                @error('description.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                         @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                        {{-- Loop untuk Input Konten Lengkap per Bahasa (CKEditor) --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'content_' . $locale">
                                    {{ __('Full Content / Details') }} ({{ strtoupper($locale) }})
                                </x-input-label>
                                <textarea id="content_{{ $locale }}" name="content[{{ $locale }}]" rows="5" class="ckeditor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content.' . $locale) }}</textarea>
                                @error('content.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                        {{-- Input Featured Image --}}
                        <div class="mb-4">
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            <input type="file" name="featured_image" id="featured_image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                             <small class="text-gray-500 mt-1">{{ __('Optional. Recommended size: 800x600px or similar ratio. Max 2MB.') }}</small>
                            @error('featured_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

