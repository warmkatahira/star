import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
	plugins: [
		laravel([
            'resources/css/app.css',
			'resources/js/app.js',
			'resources/sass/theme.scss',
            'resources/sass/navigation.scss',
            'resources/js/quantity_change.js',
		]),
	],
});