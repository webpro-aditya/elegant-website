const mix = require('laravel-mix');

const moduleDir = 'Modules/Faq/';


mix.js(moduleDir + 'Resources/js/admin/addFaq.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/addFaq.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/listFaq.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/listFaq.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/editFaq.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/editFaq.scss', 'public/css/admin');
