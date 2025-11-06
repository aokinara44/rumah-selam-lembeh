// Lokasi file: tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php', // Path Anda sudah benar
    ],

    // !! PERUBAHAN DI SINI: Tambahkan SAFELIST !!
    // Ini memberi tahu Tailwind untuk TIDAK menghapus kelas-kelas ini,
    // yang kita gunakan secara dinamis di Alpine.js untuk pin.
    safelist: [
        'text-red-600',   // Warna pin default
        'text-blue-600',  // Warna pin saat aktif
        'w-8',            // Lebar pin
        'h-8',            // Tinggi pin
    ],
    // !! AKHIR PERUBAHAN !!

    theme: {
        extend: {
            fontFamily: {
                // Gunakan Figtree sebagai font default sans-serif
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Kamu bisa menambahkan warna custom di sini jika perlu
            // colors: {
            //     'brand-blue': '#1e40af', // Contoh
            //     'brand-yellow': '#facc15', // Contoh
            // }
        },
    },

    plugins: [forms],
};