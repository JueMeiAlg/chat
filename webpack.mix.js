const mix = require('laravel-mix');

const path = require('path');

const resolve = dir => {
    return path.join(__dirname, dir)
};

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
    output: {
        // 依据该路径进行编译以及异步加载
        // publicPath: 'chunk',
        // 注意开发期间不加 hash，以免自动刷新失败
        chunkFilename: `js/chunk/chunk[name].${ mix.inProduction() ? '[chunkhash].' : '' }js`
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': resolve('resources/js'),
        }
    },
});

mix.browserSync({
    proxy: 'http://127.0.0.1:8000'
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');