const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.copy('resources/cities/' + process.env.APP_CITY.toLowerCase() + '/', 'public/images/', false);
mix.copy('resources/images/', 'public/images/', false);
mix.copy('resources/fonts/', 'public/fonts/', false);

mix.scripts([
    'resources/js/anychart-base.min.js',
    'resources/js/anychart-circular-gauge.min.js'
], 'public/js/anychart.js');

mix.styles([
    'resources/css/anychart-ui.min.css',
    'resources/css/anychart-font.min.css',
], 'public/css/anychart.css');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css').version();