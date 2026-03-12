const mix = require('laravel-mix');

const moduleDir = 'Modules/Career/';


// --------Career Category----------

mix.js(moduleDir + 'Resources/js/admin/careerCategory/addCareerCategory.js', 'public/js/admin/careerCategory');
mix.sass(moduleDir + 'Resources/sass/admin/careerCategory/addCareerCategory.scss', 'public/css/admin/careerCategory');

mix.js(moduleDir + 'Resources/js/admin/careerCategory/listCareerCategory.js', 'public/js/admin/careerCategory');
mix.sass(moduleDir + 'Resources/sass/admin/careerCategory/listCareerCategory.scss', 'public/css/admin/careerCategory');

mix.js(moduleDir + 'Resources/js/admin/careerCategory/editCareerCategory.js', 'public/js/admin/careerCategory');
mix.sass(moduleDir + 'Resources/sass/admin/careerCategory/editCareerCategory.scss', 'public/css/admin/careerCategory');


// --------Career----------

mix.js(moduleDir + 'Resources/js/admin/career/addCareer.js', 'public/js/admin/career');
mix.sass(moduleDir + 'Resources/sass/admin/career/addCareer.scss', 'public/css/admin/career');

mix.js(moduleDir + 'Resources/js/admin/career/listCareer.js', 'public/js/admin/career');
mix.sass(moduleDir + 'Resources/sass/admin/career/listCareer.scss', 'public/css/admin/career');

mix.js(moduleDir + 'Resources/js/admin/career/editCareer.js', 'public/js/admin/career');
mix.sass(moduleDir + 'Resources/sass/admin/career/editCareer.scss', 'public/css/admin/career');

mix.js(moduleDir + 'Resources/js/admin/career/viewCareer.js', 'public/js/admin/career');
mix.sass(moduleDir + 'Resources/sass/admin/career/viewCareer.scss', 'public/css/admin/career');

mix.js(moduleDir + 'Resources/js/admin/careerApplicant/viewCareerApplicant.js', 'public/js/admin/careerApplicant');
mix.sass(moduleDir + 'Resources/sass/admin/careerApplicant/viewCareerApplicant.scss', 'public/css/admin/careerApplicant');

mix.js(moduleDir + 'Resources/js/admin/careerApplicant/listCareerApplicant.js', 'public/js/admin/careerApplicant');
mix.sass(moduleDir + 'Resources/sass/admin/careerApplicant/listCareerApplicant.scss', 'public/css/admin/careerApplicant');



mix.js(moduleDir + 'Resources/js/web/hiring/hiring.js', 'public/js/web/hiring');
mix.sass(moduleDir + 'Resources/sass/web/hiring/hiring.scss', 'public/css/web/hiring');

mix.js(moduleDir + 'Resources/js/web/hiring/careerCard.js', 'public/js/web/hiring');

