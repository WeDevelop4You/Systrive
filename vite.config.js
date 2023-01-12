import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue2';
import laravel from 'laravel-vite-plugin';
import Components from 'unplugin-vue-components/vite';
import { VuetifyResolver } from 'unplugin-vue-components/resolvers';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm.browser.js'
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/App/Admin/App.js',
                'resources/App/Account/App.js',
                'resources/App/Company/App.js',

                'resources/Support/Scss/TinyMCE/skin.scss',
                'resources/Support/Scss/TinyMCE/content.scss',
                'resources/Support/Scss/TinyMCE/skin.shadowdom.scss'
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
                VuetifyResolver(),
            ],
        }),
    ],
    css: {
        preprocessorOptions: {
            sass: {
                additionalData: [
                    '@import "./resources/Support/Scss/Variables"',
                    '',
                ].join('\n'),
            },
        },
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: ({name}) => {
                    const regex = /(?:\.([^.]+))?$/
                    const paths = name.split('/')

                    if (paths.at(-2) === 'TinyMCE') {
                        return 'assets/css/tinymce/[name].min.[ext]'
                    }

                    switch (regex.exec(name).at(1)) {
                        case 'css':
                            return 'assets/css/[hash].[ext]'
                        case 'svg':
                            return 'assets/svg/[hash].[ext]'
                        default:
                            return 'assets/font/[hash].[ext]'
                    }
                },
                entryFileNames: 'assets/js/[hash].js',
                chunkFileNames: 'assets/js/[hash].js'
            }
        }
    }
});
