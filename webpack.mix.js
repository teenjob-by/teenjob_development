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
mix.webpackConfig(webpack => {
    return {
        resolve: {
            alias: { jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js') }
        },

        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
            })
        ]
    };
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/backend/app.js', 'public/js/backend')
    .sass('resources/sass/backend/app.scss', 'public/css/backend');

if (mix.inProduction()) {
    mix.version();
}


