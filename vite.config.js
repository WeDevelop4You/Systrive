import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue2';
import laravel from 'laravel-vite-plugin';
import Components from 'unplugin-vue-components/vite';
import { VuetifyResolver } from 'unplugin-vue-components/resolvers';

function createFileNamePath({name}) {

}

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm.browser.js'
        }
    },
    plugins: [
        laravel([
            'resources/admin/js/app.js',
        ]),
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
                    '@import "./resources/admin/sass/variables"',
                    '',
                ].join('\n'),
            },
        },
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: ({name}) => {
                    const regex = /(?:\.([^.]+))?$/;

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
