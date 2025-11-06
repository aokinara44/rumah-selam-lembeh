<?php
// Lokasi File: resources/views/admin/reviews/create.blade.php
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- TAMBAHKAN enctype="multipart/form-data" UNTUK UPLOAD FILE --}}
                    <form action="{{ route('admin.reviews.store', ['locale' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div x-data="{ tab: 'en' }" class="mb-4">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button type="button" @click="tab = 'en'" :class="tab === 'en' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        English
                                    </button>
                                    <button type="button" @click="tab = 'nl'" :class="tab === 'nl' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Dutch
                                    </button>
                                    <button type="button" @click="tab = 'zh'" :class="tab === 'zh' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Chinese
                                    </button>
                                </nav>
                            </div>

                            <div x-show="tab === 'en'" class="pt-4">
                                <div class="mb-4">
                                    <x-input-label for="reviewer_name_en" :value="__('Reviewer Name (EN)')" />
                                    <x-text-input id="reviewer_name_en" class="block mt-1 w-full" type="text" name="reviewer_name[en]" :value="old('reviewer_name.en')" required />
                                    <x-input-error :messages="$errors->get('reviewer_name.en')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="review_text_en" :value="__('Review Text (EN)')" />
                                    <textarea id="review_text_en" name="review_text[en]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ old('review_text.en') }}</textarea>
                                    <x-input-error :messages="$errors->get('review_text.en')" class="mt-2" />
                                </div>
                            </div>
                            <div x-show="tab === 'nl'" class="pt-4" style="display: none;">
                                <div class="mb-4">
                                    <x-input-label for="reviewer_name_nl" :value="__('Reviewer Name (NL)')" />
                                    <x-text-input id="reviewer_name_nl" class="block mt-1 w-full" type="text" name="reviewer_name[nl]" :value="old('reviewer_name.nl')" />
                                    <x-input-error :messages="$errors->get('reviewer_name.nl')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="review_text_nl" :value="__('Review Text (NL)')" />
                                    <textarea id="review_text_nl" name="review_text[nl]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ old('review_text.nl') }}</textarea>
                                    <x-input-error :messages="$errors->get('review_text.nl')" class="mt-2" />
                                </div>
                            </div>
                            <div x-show="tab === 'zh'" class="pt-4" style="display: none;">
                                <div class="mb-4">
                                    <x-input-label for="reviewer_name_zh" :value="__('Reviewer Name (ZH)')" />
                                    <x-text-input id="reviewer_name_zh" class="block mt-1 w-full" type="text" name="reviewer_name[zh]" :value="old('reviewer_name.zh')" />
                                    <x-input-error :messages="$errors->get('reviewer_name.zh')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="review_text_zh" :value="__('Review Text (ZH)')" />
                                    <textarea id="review_text_zh" name="review_text[zh]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ old('review_text.zh') }}</textarea>
                                    <x-input-error :messages="$errors->get('review_text.zh')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating')" />
                            <select name="rating" id="rating" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars</option>
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star</option>
                            </select>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="reviewer_photo" :value="__('Reviewer Photo')" />
                            <x-text-input id="reviewer_photo" class="block mt-1 w-full file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="reviewer_photo" />
                            <x-input-error :messages="$errors->get('reviewer_photo')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="is_visible" class="inline-flex items-center">
                                <input id="is_visible" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Visible on website') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('is_visible')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.reviews.index', ['locale' => app()->getLocale()]) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>