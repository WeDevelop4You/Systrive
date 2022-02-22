const mix = require('laravel-mix')

require('vuetifyjs-mix-extension')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/admin/js/app.js', 'public/js/admin')
    .sass('resources/admin/sass/custom.scss', 'public/css/admin')
    .vuetify('vuetify-loader', 'resources/admin/sass/variables.scss', {
        extract: 'css/admin/app.css',
    })
    .vue({ version: 2 })

// mix.js('resources/site/js/app.js', 'public/js/site')
//     .sass('resources/site/sass/app.scss', 'public/css/site')
