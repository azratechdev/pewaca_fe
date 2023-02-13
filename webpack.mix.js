const mix = require('laravel-mix');

// set path to laravel public directory
//mix.setPublicPath('public');

// path to laravel public directory from public/css/app.css
mix.setResourceRoot("../");

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');