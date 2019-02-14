let mix = require('laravel-mix');
let tailwind = require('laravel-mix-tailwind');

mix.sass('resources/sass/main.sass', 'static/css/main.css')
    .tailwind()
    .browserSync({
        files: ['./**/*.php','./**/*.sass', './**/*.js'],
        proxy: 'chakravyuh.test'
    });