{{-- resources/views/admin/gallery-categories/create.blade.php --}}
<x-app-layout>
    {{-- Slot header untuk judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Gallery Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Form mengarah ke route store --}}
                    <form method="POST" action="{{ route('admin.gallery-categories.store') }}">
                        @csrf

                        {{-- Loop untuk setiap bahasa yang tersedia di config/app.php --}}
                        @foreach(config('app.available_locales') as $locale => $localeName)
                            <div class="mb-4">
                                {{-- Label input dengan kode bahasa --}}
                                <x-input-label :for="'name_' . $locale">
                                    {{ __('Name') }} ({{ strtoupper($locale) }})
                                    {{-- Tandai bahasa Inggris sebagai wajib --}}
                                    @if($locale === 'en') <span class="text-red-500">*</span> @endif
                                </x-input-label>

                                {{-- Input text untuk setiap bahasa --}}
                                <x-text-input
                                    :id="'name_' . $locale"
                                    class="block mt-1 w-full"
                                    type="text"
                                    {{-- Nama input menggunakan format array: name[en], name[nl], name[zh] --}}
                                    :name="'name[' . $locale . ']'"
                                    {{-- Ambil nilai lama jika ada error validasi --}}
                                    :value="old('name.' . $locale)"
                                    {{-- Atribut required hanya untuk bahasa Inggris --}}
                                    :required="$locale === 'en'"
                                    {{-- Autofocus pada input bahasa Inggris --}}
                                    autofocus="{{ $locale === 'en' }}" />

                                {{-- Tampilkan pesan error validasi spesifik per bahasa --}}
                                @error('name.' . $locale)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        {{-- Tampilkan pesan error umum untuk field 'name' (misal jika array kosong) --}}
                        @error('name')
                           <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Tombol Submit --}}
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