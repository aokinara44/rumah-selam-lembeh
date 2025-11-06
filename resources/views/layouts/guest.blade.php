<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rumah Selam DC') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100" style="background-image: url('https://source.unsplash.com/1600x900/?underwater,coral'); background-size: cover; background-position: center;">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bg-opacity-90 shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex justify-center mb-4">
                    <a href="/">
                        <span class="text-2xl font-bold text-gray-700">Rumah Selam</span>
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

