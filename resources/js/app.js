import './bootstrap';

export default defineConfig({
    plugins: [laravel({
        input: ['resources/js/app.js', 'resources/js/app.tsx'],
        refresh: true,
    })],
});