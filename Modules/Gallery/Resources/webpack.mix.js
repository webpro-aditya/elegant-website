const mix = require('laravel-mix');

const moduleDir = 'Modules/Gallery/';

mix.js(moduleDir + 'Resources/js/admin/addGallery.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/addGallery.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/listGallery.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/listGallery.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/admin/editGallery.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/editGallery.scss', 'public/css/admin');

mix.js(moduleDir + 'Resources/js/web/gallery/gallery.js', 'public/js/web/gallery');
mix.sass(moduleDir + 'Resources/sass/web/gallery/gallery.scss', 'public/css/web/gallery');
