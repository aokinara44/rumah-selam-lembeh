// Lokasi File: vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'; // <-- Import plugin

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        // <-- Tambahkan blok ini untuk menyalin aset TinyMCE -->
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/tinymce/*', // Sumber
                    dest: 'tinymce' // Tujuan di dalam folder public/build/assets
                }
            ]
        })
        // <-- Akhir blok tambahan -->
    ],
});