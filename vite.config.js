import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/messagerie.js'
            ],
            refresh: true,
        }),
    ],
    define: {
        'process.env': {},
        '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': 'false'
    },
});
