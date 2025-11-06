// tailwind.config.js

// !! PERBAIKAN DI SINI: Import 'typography' !!
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography'; // <-- !! TAMBAHKAN BARIS INI !!

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php', 
    ],

    // Safelist yang kamu tambahkan sudah benar, kita biarkan
    safelist: [
        'text-red-600',
        'text-blue-600',
        'w-8',
        'h-8',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // !! PERBAIKAN DI SINI: Daftarkan 'typography' !!
    plugins: [
        forms,
        typography // <-- !! TAMBAHKAN BARIS INI !!
    ],
};