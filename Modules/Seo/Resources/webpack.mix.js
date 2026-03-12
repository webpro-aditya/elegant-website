const mix = require('laravel-mix');

const moduleDir = 'Modules/Seo/';

mix.js(moduleDir + 'Resources/js/admin/seo/listSeo.js', 'public/js/admin/seo');
mix.sass(moduleDir + 'Resources/sass/admin/seo/listSeo.scss', 'public/css/admin/seo');

mix.js(moduleDir + 'Resources/js/admin/seo/addSeo.js', 'public/js/admin/seo');
mix.sass(moduleDir + 'Resources/sass/admin/seo/addSeo.scss', 'public/css/admin/seo');

mix.js(moduleDir + 'Resources/js/admin/seo/editSeo.js', 'public/js/admin/seo');
mix.sass(moduleDir + 'Resources/sass/admin/seo/editSeo.scss', 'public/css/admin/seo');