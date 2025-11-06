<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Contact') }}: {{ $contact->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name (Internal)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $contact->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Example: "Admin WhatsApp", "Main Instagram", "Office Address"</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Contact Type')" />
                            <select name="type" id="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="phone" {{ old('type', $contact->type) == 'phone' ? 'selected' : '' }}>Phone</option>
                                <option value="email" {{ old('type', $contact->type) == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="social" {{ old('type', $contact->type) == 'social' ? 'selected' : '' }}>Social Media</option>
                                <option value="address" {{ old('type', $contact->type) == 'address' ? 'selected' : '' }}>Address</option>
                                <option value="qr_code" {{ old('type', $contact->type) == 'qr_code' ? 'selected' : '' }}>QR Code</option> {{-- <-- 1. DITAMBAHKAN --}}
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="value" :value="__('Value (The Content)')" />
                            <textarea id="value" name="value" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('value', $contact->value) }}</textarea>
                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                            {{-- 2. DIUBAH --}}
                            <p class="mt-1 text-sm text-gray-500">Enter the phone number, email, full URL, full address, or image path (e.g., images/wechat-qr.png).</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="icon_svg" :value="__('Icon SVG (Optional)')" />
                            <textarea id="icon_svg" name="icon_svg" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('icon_svg', $contact->icon_svg) }}</textarea>
                            <x-input-error :messages="$errors->get('icon_svg')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Paste the full SVG code for the icon (e.g., from FontAwesome).</p>
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" @checked(old('is_active', $contact->is_active))>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Show this contact on the website?') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>