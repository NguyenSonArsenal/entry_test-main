import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/css/app.css',
                // 'resources/js/app.js',
                // 'resources/scss/**/*.scss',
                // 'resources/css/**/*.css',

                'resources/scss/admin/home.scss',
                'resources/scss/admin/result.scss',
                'resources/scss/admin/search.scss',
                'resources/scss/admin/side-menu.scss',
                'resources/scss/user/common.scss',
                'resources/scss/user/home.scss',
                'resources/scss/user/hotedetail.scss',
                'resources/scss/user/hotellist.scss',
                'resources/css/app.css',
                'resources/css/reset.css',
                'resources/css/admin/base.css',
                'resources/css/user/base.css',
            ],
            refresh: true,
        }),
    ],
    // @see https://readouble.com/laravel/11.x/en/vite.html#running-the-development-server-in-sail-on-wsl2:~:text=run%20dev%20command.-,Running%20the%20Development%20Server%20in%20Sail%20on%20WSL2,-When%20running%20the
    // server: {
    //     hmr: {
    //         hmr: false,
    //     },
    //     // @see https://vite.dev/config/server-options.html#server-watch
    //     watch: {
    //         usePolling: true
    //     }
    // },

    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
