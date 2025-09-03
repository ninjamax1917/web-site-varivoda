import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/webrtc-client.js',
                'resources/js/modal-stream.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
