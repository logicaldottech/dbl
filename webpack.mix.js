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

mix.react('resources/js/app.js', 'public/js')
.react('resources/js/other.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
	host: '192.168.10.10',
    proxy: 'http://homestead.test/app',
    open: false,

	files: [
		  'public/css/**/*',
		  'public/js/**/*',
		],

		 watchOptions: {
      usePolling: true,
      interval: 500,
    },
});
