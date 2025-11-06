<x-main-layout>
    @section('title', $post->title . ' - Rumah Selam Lembeh Blog')
    @section('description', $post->excerpt ?? Str::limit(strip_tags($post->body), 155))

    <article class="py-12 sm:py-16">
        <div class="container mx-auto px-6 max-w-4xl">

            {{-- Breadcrumb Navigation --}}
            <div class="mb-8 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <span class="mx-2">&gt;</span>
                <a href="{{ route('blog') }}" class="hover:text-blue-600">Blog</a>
                <span class="mx-2">&gt;</span>
                <span class="text-gray-800">{{ Str::limit($post->title, 30) }}</span>
            </div>

            {{-- Post Header --}}
            <header class="mb-8">
                <div class="mb-4">
                    <span class="text-sm text-blue-500 font-semibold">{{ $post->postCategory->name ?? 'Uncategorized' }}</span>
                    <span class="text-sm text-gray-500 mx-1">&bull;</span>
                    <span class="text-sm text-gray-500">Published on {{ \Carbon\Carbon::parse($post->published_at)->format('F d, Y') }}</span>
                    <span class="text-sm text-gray-500 mx-1">&bull;</span>
                    <span class="text-sm text-gray-500">by {{ $post->user->name ?? 'Admin' }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>
            </header>

            {{-- Featured Image --}}
            @if($post->featured_image)
                <figure class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
                </figure>
            @endif

            {{-- Post Content --}}
            <div class="prose prose-lg max-w-none text-gray-800">
                {!! nl2br(e($post->body)) !!}
            </div>

            {{-- Back to Blog Button --}}
            <div class="mt-12 border-t pt-8">
                <a href="{{ route('blog') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to all posts
                </a>
            </div>

        </div>
    </article>

</x-main-layout>
