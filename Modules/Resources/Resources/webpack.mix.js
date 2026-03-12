const mix = require('laravel-mix');

const moduleDir = 'Modules/Resources/';

mix.js(moduleDir + 'Resources/js/admin/freeResource/addFreeResource.js', 'public/js/admin/freeResource');
mix.sass(moduleDir + 'Resources/sass/admin/freeResource/addFreeResource.scss', 'public/css/admin/freeResource');

mix.js(moduleDir + 'Resources/js/admin/freeResource/listFreeResource.js', 'public/js/admin/freeResource');
mix.sass(moduleDir + 'Resources/sass/admin/freeResource/listFreeResource.scss', 'public/css/admin/freeResource');

mix.js(moduleDir + 'Resources/js/admin/freeResource/editFreeResource.js', 'public/js/admin/freeResource');
mix.sass(moduleDir + 'Resources/sass/admin/freeResource/editFreeResource.scss', 'public/css/admin/freeResource');

mix.js(moduleDir + 'Resources/js/admin/freeResource/viewFreeResource.js', 'public/js/admin/freeResource');
mix.sass(moduleDir + 'Resources/sass/admin/freeResource/viewFreeResource.scss', 'public/css/admin/freeResource');

mix.js(moduleDir + 'Resources/js/admin/resourceContent/listResourceContent.js', 'public/js/admin/resourceContent');

mix.js(moduleDir + 'Resources/js/admin/resourceContent/addResourceContent.js', 'public/js/admin/resourceContent');
mix.sass(moduleDir + 'Resources/sass/admin/resourceContent/addResourceContent.scss', 'public/css/admin/resourceContent');

mix.js(moduleDir + 'Resources/js/admin/resourceContent/editResourceContent.js', 'public/js/admin/resourceContent');
mix.sass(moduleDir + 'Resources/sass/admin/resourceContent/editResourceContent.scss', 'public/css/admin/resourceContent');

mix.js(moduleDir + 'Resources/js/admin/quiz/listQuizContent.js', 'public/js/admin/quiz');
mix.sass(moduleDir + 'Resources/sass/admin/quiz/listQuizContent.scss', 'public/css/admin/quiz');

mix.js(moduleDir + 'Resources/js/admin/quiz/addQuizContent.js', 'public/js/admin/quiz');
mix.sass(moduleDir + 'Resources/sass/admin/quiz/addQuizContent.scss', 'public/css/admin/quiz');


mix.js(moduleDir + 'Resources/js/admin/quiz/editQuizContent.js', 'public/js/admin/quiz');
mix.sass(moduleDir + 'Resources/sass/admin/quiz/editQuizContent.scss', 'public/css/admin/quiz');

// web

mix.js(moduleDir + 'Resources/js/web/detail.js', 'public/js/web');
mix.sass(moduleDir + 'Resources/sass/web/detail.scss', 'public/css/web');

mix.js(moduleDir + 'Resources/js/web/quiz.js', 'public/js/web');
mix.sass(moduleDir + 'Resources/sass/web/quiz.scss', 'public/css/web');

mix.js(moduleDir + 'Resources/js/web/analysis.js', 'public/js/web');
mix.sass(moduleDir + 'Resources/sass/web/analysis.scss', 'public/css/web');

mix.js(moduleDir + 'Resources/js/web/solution.js', 'public/js/web');
mix.sass(moduleDir + 'Resources/sass/web/solution.scss', 'public/css/web');

mix.js(moduleDir + 'Resources/js/web/quiz/form.js', 'public/js/web/quiz');