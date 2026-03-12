const mix = require('laravel-mix');

const moduleDir = 'Modules/Cms/';

mix.js(moduleDir + 'Resources/js/admin/pages/listPage.js', 'public/js/admin/pages');
mix.sass(moduleDir + 'Resources/sass/admin/pages/listPage.scss', 'public/css/admin/pages');

mix.js(moduleDir + 'Resources/js/admin/contents/listContent.js', 'public/js/admin/contents');
mix.sass(moduleDir + 'Resources/sass/admin/contents/listContent.scss', 'public/css/admin/contents');

mix.js(moduleDir + 'Resources/js/admin/contents/addContent.js', 'public/js/admin/contents');
mix.sass(moduleDir + 'Resources/sass/admin/contents/addContent.scss', 'public/css/admin/contents');

mix.js(moduleDir + 'Resources/js/admin/contents/editContent.js', 'public/js/admin/contents');
mix.sass(moduleDir + 'Resources/sass/admin/contents/editContent.scss', 'public/css/admin/contents');

mix.js(moduleDir + 'Resources/js/admin/contents/viewContent.js', 'public/js/admin/contents');
mix.sass(moduleDir + 'Resources/sass/admin/contents/viewContent.scss', 'public/css/admin/contents');

mix.js(moduleDir + 'Resources/js/web/about/about.js', 'public/js/web/about');
mix.sass(moduleDir + 'Resources/sass/web/about/about.scss', 'public/css/web/about');

mix.js(moduleDir + 'Resources/js/web/corporate-training/corporate-training.js', 'public/js/web/corporate-training');
mix.sass(moduleDir + 'Resources/sass/web/corporate-training/corporate-training.scss', 'public/css/web/corporate-training');

mix.js(moduleDir + 'Resources/js/web/mentor/mentor.js', 'public/js/web/mentor');
mix.sass(moduleDir + 'Resources/sass/web/mentor/mentor.scss', 'public/css/web/mentor');

mix.js(moduleDir + 'Resources/js/web/privacy/privacyPolicy.js', 'public/js/web/privacy');
mix.sass(moduleDir + 'Resources/sass/web/privacy/privacyPolicy.scss', 'public/css/web/privacy');

mix.js(moduleDir + 'Resources/js/web/privacy/termsAndConditions.js', 'public/js/web/privacy');
mix.sass(moduleDir + 'Resources/sass/web/privacy/termsAndConditions.scss', 'public/css/web/privacy');
// mix.js(moduleDir + 'Resources/js/web/help/help.js', 'public/js/web/help');
// mix.sass(moduleDir + 'Resources/sass/web/help/help.scss', 'public/css/web/help');

// mix.js(moduleDir + 'Resources/js/web/consultancy/consultancy.js', 'public/js/web/consultancy');
// mix.sass(moduleDir + 'Resources/sass/web/consultancy/consultancy.scss', 'public/css/web/consultancy');

// mix.js(moduleDir + 'Resources/js/web/competency/competency.js', 'public/js/web/competency');
// mix.sass(moduleDir + 'Resources/sass/web/competency/competency.scss', 'public/css/web/competency');

// mix.js(moduleDir + 'Resources/js/web/documentation/documentation.js', 'public/js/web/documentation');
// mix.sass(moduleDir + 'Resources/sass/web/documentation/documentation.scss', 'public/css/web/documentation');