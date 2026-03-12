const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

require('laravel-mix-merge-manifest');
mix.mergeManifest();

/*
 |--------------------------------------------------------------------------
 | Admin Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * misc
 **/
mix.copy('resources/images', 'public/images');
mix.copy('resources/json/flags', 'public/images/flags');
mix.copy('node_modules/tinymce/skins', 'public/css/tinymce/skins');

/**
 * layouts
 */
mix.sass('resources/sass/plugins.scss', 'public/css/layouts/plugins.css');
mix.sass('resources/sass/app.scss', 'public/css/layouts/app.css'); 

mix.sass('resources/sass/web/plugins.scss', 'public/css/layouts/web/plugins.css');
mix.sass('resources/sass/web/app.scss', 'public/css/layouts/web/app.css'); 
 

const moduleFolder = './Modules';

const dirs = p => fs.readdirSync(p).filter(f => fs.statSync(path.resolve(p, f)).isDirectory())

let modules = dirs(moduleFolder);

modules.forEach(function(m) {
    require(`${moduleFolder}/${m}/Resources/webpack.mix.js`);
});