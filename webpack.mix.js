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

 var webpack = require('webpack')
 var jquery = require('jquery')
 
 module.exports = {
    plugins: [
       new webpack.ProvidePlugin({
          $: "jquery",
          jQuery: "jquery"
       })
    ]
 }

mix. js('resources/js/app.js', 'public/js/app.js')
    .js('resources/assets/modules/login/login.js', 'public/js/login.js')
    .js('resources/assets/modules/password/password.js', 'public/js/password.js')
    .js('resources/assets/modules/session.js', 'public/js/session.js')
    // .js('resources/assets/modules/main.js', 'public/js/main.js')
    .vue()
    // .sass('resources/sass/app.scss', 'public/css');
