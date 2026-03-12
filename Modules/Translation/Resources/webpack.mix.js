const mix = require('laravel-mix');

const moduleDir = 'Modules/Translation/';


mix.js(moduleDir + 'Resources/js/admin/translation/viewTranslation.js', 'public/js/admin/translation');
mix.sass(moduleDir + 'Resources/sass/admin/translation/viewTranslation.scss', 'public/css/admin/translation');