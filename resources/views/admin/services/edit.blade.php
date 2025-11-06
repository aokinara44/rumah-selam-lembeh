{{-- resources/views/admin/services/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    {{-- Script untuk CKEditor --}}
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.ckeditor').forEach(function(element) {
                    ClassicEditor
                        .create(element)
                        .catch(error => {
                            console.error(error);
                        });
                });
            });
        </script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Form mengarah ke route update dengan method PUT dan enctype --}}
                    <form method="POST" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Dropdown Kategori Layanan --}}
                        <div class="mb-4">
                            <x-input-label for="service_category_id" :value="__('Service Category')" />
                            <select name="service_category_id" id="service_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('service_category_id', $service->service_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
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
                                <x-text-input :id="'title_' . $locale" class="block mt-1 w-full" type="text" :name="'title[' . $locale . ']'" 
                                              :value="old('title.' . $locale, $service->getTranslation('title', $locale))" 
                                              :required="$locale === 'en'" autofocus="{{ $locale === 'en' }}" />
                                @error('title.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                         {{-- Loop untuk Input Deskripsi Singkat per Bahasa --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'description_' . $locale">
                                    {{ __('Short Description') }} ({{ strtoupper($locale) }})
                                </x-input-label>
                                <textarea id="description_{{ $locale }}" name="description[{{ $locale }}]" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description.' . $locale, $service->getTranslation('description', $locale)) }}</textarea>
                                @error('description.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                         @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                        {{-- Loop untuk Input Konten Lengkap per Bahasa --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'content_' . $locale">
                                    {{ __('Full Content / Details') }} ({{ strtoupper($locale) }})
                                </x-input-label>
                                <textarea id="content_{{ $locale }}" name="content[{{ $locale }}]" rows="5" class="ckeditor block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content.' . $locale, $service->getTranslation('content', $locale)) }}</textarea>
                                @error('content.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                        {{-- Input Featured Image --}}
                        <div class="mb-4">
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            <input type="file" name="featured_image" id="featured_image" class="block mt-1 w-full border border-gray-300 p-2 rounded-md shadow-sm">
                            <small class="text-gray-500">{{ __('Leave empty to keep the current image.') }}</small>
                            @error('featured_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            {{-- Tampilkan gambar saat ini jika ada --}}
                            @if($service->featured_image)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-1">{{ __('Current Image:') }}</p>
                                <img src="{{ Storage::url($service->featured_image) }}" alt="{{ $service->title }}" class="w-48 h-auto rounded">
                            </div>
                            @endif
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
