const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/upload.js", "public/js")
    .js("resources/js/profile.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/profile.scss", "public/css")
    .sass("resources/sass/feed.scss", "public/css")
    .sass("resources/sass/post.scss", "public/css")
    .copyDirectory("database/seeds/assets/", "storage/app/public");
