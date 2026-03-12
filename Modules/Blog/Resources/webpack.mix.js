const mix = require('laravel-mix');

const moduleDir = 'Modules/Blog/';

mix.js(moduleDir + 'Resources/js/admin/blogcategory/addBlogCategory.js', 'public/js/admin/blogcategory');
mix.sass(moduleDir + 'Resources/sass/admin/blogcategory/addBlogCategory.scss', 'public/css/admin/blogcategory');

mix.js(moduleDir + 'Resources/js/admin/blogcategory/listBlogCategory.js', 'public/js/admin/blogcategory');
mix.sass(moduleDir + 'Resources/sass/admin/blogcategory/listBlogCategory.scss', 'public/css/admin/blogcategory');

mix.js(moduleDir + 'Resources/js/admin/blogcategory/editBlogCategory.js', 'public/js/admin/blogcategory');
mix.sass(moduleDir + 'Resources/sass/admin/blogcategory/editBlogCategory.scss', 'public/css/admin/blogcategory');

mix.js(moduleDir + 'Resources/js/admin/blog/addBlog.js', 'public/js/admin/blog');
mix.sass(moduleDir + 'Resources/sass/admin/blog/addBlog.scss', 'public/css/admin/blog');

mix.js(moduleDir + 'Resources/js/admin/blog/listBlog.js', 'public/js/admin/blog');
mix.sass(moduleDir + 'Resources/sass/admin/blog/listBlog.scss', 'public/css/admin/blog');

mix.js(moduleDir + 'Resources/js/admin/blog/editBlog.js', 'public/js/admin/blog');
mix.sass(moduleDir + 'Resources/sass/admin/blog/editBlog.scss', 'public/css/admin/blog');


mix.js(moduleDir + 'Resources/js/admin/blog/viewBlog.js', 'public/js/admin/blog');
mix.sass(moduleDir + 'Resources/sass/admin/blog/viewBlog.scss', 'public/css/admin/blog');


// mix.js('Modules/Cms/Resources/js/admin/contents/addContent.js', 'public/js/admin/contents');
// mix.js('Modules/Cms/Resources/js/admin/contents/editContent.js', 'public/js/admin/contents');



mix.js(moduleDir + 'Resources/js/web/list.js', 'public/js/web/blog');
mix.sass(moduleDir + 'Resources/sass/web/list.scss', 'public/css/web/blog');

mix.js(moduleDir + 'Resources/js/web/category.js', 'public/js/web/blog');
mix.sass(moduleDir + 'Resources/sass/web/category.scss', 'public/css/web/blog');

mix.js(moduleDir + 'Resources/js/web/detail.js', 'public/js/web/blog');
mix.sass(moduleDir + 'Resources/sass/web/detail.scss', 'public/css/web/blog');

mix.js(moduleDir + 'Resources/js/web/author/list.js', 'public/js/web/blog/author');
mix.sass(moduleDir + 'Resources/sass/web/author/list.scss', 'public/css/web/blog/author');
