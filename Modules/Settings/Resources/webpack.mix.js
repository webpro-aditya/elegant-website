const mix = require('laravel-mix');

const moduleDir = 'Modules/Settings/';

/**
 * Settings
 */
mix.js(moduleDir + 'Resources/js/branding.js', 'public/js/settings');
mix.sass(moduleDir + 'Resources/sass/branding.scss', 'public/css/settings');
mix.js(moduleDir + 'Resources/js/settings.js', 'public/js/settings');
mix.sass(moduleDir + 'Resources/sass/settings.scss', 'public/css/settings');
mix.js(moduleDir + 'Resources/js/socialSettings.js', 'public/js/settings');
mix.sass(moduleDir + 'Resources/sass/socialSettings.scss', 'public/css/settings');

mix.js(moduleDir + 'Resources/js/seo.js', 'public/js/settings');
mix.sass(moduleDir + 'Resources/sass/seo.scss', 'public/css/settings');