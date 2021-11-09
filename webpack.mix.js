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
mix.webpackConfig({
    resolve: {
        fallback: {
            "fs": false,
            "tls": false,
           
            "zlib": false,
            "http": false,
            "https": false,
            "stream": false,
            "crypto": false,
            "domain": false,
            "os": false,
            "dgram":false,
            "timers": require.resolve("timers-browserify") ,
            "crypto-browserify": require.resolve('crypto-browserify'), //if you want to use this module also don't forget npm i crypto-browserify 
          } 
    }
}); 
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/mikrotik/mikrotik.js','public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
