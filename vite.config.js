import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: 'cms-contact_management_system.test',
        port: 5173,
        hmr: {
            protocol: 'wss',
            host: 'cms-contact_management_system.test',
            port: 5173,
        },
    },
});
