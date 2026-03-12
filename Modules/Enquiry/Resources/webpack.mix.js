const mix = require('laravel-mix');

const moduleDir = 'Modules/Enquiry/';

mix.js(moduleDir + 'Resources/js/admin/enquiry/listEnquiry.js', 'public/js/admin/enquiry');
mix.sass(moduleDir + 'Resources/sass/admin/enquiry/listEnquiry.scss', 'public/css/admin/enquiry');

mix.js(moduleDir + 'Resources/js/admin/enquiry/detailEnquiry.js', 'public/js/admin/enquiry');
mix.sass(moduleDir + 'Resources/sass/admin/enquiry/detailEnquiry.scss', 'public/css/admin/enquiry');

mix.js(moduleDir + 'Resources/js/admin/brochure/listBrochure.js', 'public/js/admin/brochure');
mix.sass(moduleDir + 'Resources/sass/admin/brochure/listBrochure.scss', 'public/css/admin/brochure');



mix.js(moduleDir + 'Resources/js/web/contactus.js', 'public/js/web');
mix.sass(moduleDir + 'Resources/sass/web/contactus.scss', 'public/css/web');