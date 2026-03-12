const mix = require('laravel-mix');

const moduleDir = 'Modules/Author/';


mix.js(moduleDir + 'Resources/js/admin/addAuthor.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/addAuthor.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/listAuthor.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/listAuthor.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/editAuthor.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/editAuthor.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/viewAuthor.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/viewAuthor.scss', 'public/css/admin');
