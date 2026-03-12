const mix = require('laravel-mix');

require('laravel-mix-merge-manifest');
mix.mergeManifest();

const moduleDir = 'Modules/Auth/';

/**
 * Auth
 */

// admin
mix.js(moduleDir + 'Resources/js/admin/login.js', 'public/js/auth/admin');
mix.sass(moduleDir + 'Resources/sass/admin/login.scss', 'public/css/auth/admin');

