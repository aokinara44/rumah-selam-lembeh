<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Gallery Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Form harus 'multipart/form-data' untuk upload file --}}
                    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="gallery_category_id" :value="__('Category')" />
                            <select id="gallery_category_id" name="gallery_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select Category') }}</option>
                                {{-- Loop kategori dari controller --}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('gallery_category_id') == $category->id ? 'selected' : '' }}>
                                        {{-- Tampilkan nama kategori dalam B.Inggris --}}
                                        {{ $category->getTranslation('name', 'en') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gallery_category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Title Multi-bahasa --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                <x-input-label :for="'title_' . $locale">
                                    {{ __('Title / Caption') }} ({{ strtoupper($locale) }})
                                    @if($locale === 'en') <span class="text-red-500">*</span> @endif
                                </x-input-label>
                                <x-text-input
                                    :id="'title_' . $locale"
                                    class="block mt-1 w-full"
                                    type="text"
                                    :name="'title[' . $locale . ']'"
                                    :value="old('title.' . $locale)"
                                    :required="$locale === 'en'"
                                    autofocus="{{ $locale === 'en' }}" />
                                @error('title.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        @error('title')
                           <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Image(s)')" />
                            <input id="image"
                                   {{-- Ganti 'name' menjadi 'images[]' untuk array --}}
                                   name="images[]"
                                   type="file"
                                   class="block mt-1 w-full"
                                   required
                                   {{-- Tambahkan 'multiple' untuk upload banyak file --}}
                                   multiple />
                            <p class="text-sm text-gray-500 mt-1">You can select multiple images at once.</p>

                            {{-- Error handling untuk array --}}
                            @error('images')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>