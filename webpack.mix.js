const mix = require('laravel-mix');


var WebpackSystemRegister = require('webpack-system-register');
 
module.exports = {
  output: {
    filename: "my-bundle.js",
    publicPath: null, // This MUST not be set when using `useSystemJSLocateDir`
  },
  plugins: [
    new WebpackSystemRegister({
      registerName: 'my-bundle', // required when using `useSystemJSLocateDir`
      publicPath: {
        useSystemJSLocateDir: true, // if this is set to true, publicPath must be omitted and registerName must be provided
      }
    })
  ]
}
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
            fs: require.resolve('browserify-fs'),
            path: require.resolve("path-browserify"),
            "crypto": require.resolve("crypto-browserify"),
            "https": require.resolve("https-browserify"),
            "http": require.resolve("stream-http"),
            "vm": require.resolve("vm-browserify"),
            "os": require.resolve("os-browserify/browser"),
            "stream": require.resolve("stream-browserify"),
            "constants": require.resolve("constants-browserify"),
            "dgram":  require.resolve("dgram-browserify"), // do not include a polyfill for dgram,
            "child_process": false,
            "timers": require.resolve("timers-browserify")
        }
    }
})
mix.options({ legacyNodePolyfills: false });

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/mikrotik/mikrotik.js','public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
