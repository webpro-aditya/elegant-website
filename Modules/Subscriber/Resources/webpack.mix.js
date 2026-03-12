const mix = require('laravel-mix');

const moduleDir = 'Modules/Subscriber/';

mix.js(moduleDir + 'Resources/js/admin/listSubscriber.js', 'public/js/admin');
mix.sass(moduleDir + 'Resources/sass/admin/listSubscriber.scss', 'public/css/admin');