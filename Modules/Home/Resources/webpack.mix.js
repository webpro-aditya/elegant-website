const mix = require('laravel-mix');

const moduleDir = 'Modules/Home/';


/**
 * Web
 */

mix.js(moduleDir + 'Resources/js/admin/dashboard.js', 'public/js/admin/home');
mix.sass(moduleDir + 'Resources/sass/admin/dashboard.scss', 'public/css/admin/home');


mix.js(moduleDir + 'Resources/js/web/home.js', 'public/js/web/home');
mix.sass(moduleDir + 'Resources/sass/web/home.scss', 'public/css/web/home');


