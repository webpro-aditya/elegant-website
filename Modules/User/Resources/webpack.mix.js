const mix = require('laravel-mix');

const moduleDir = 'Modules/User/';

/**
 * Roles
 */
mix.js(moduleDir + 'Resources/js/roles/addRole.js', 'public/js/roles');
mix.js(moduleDir + 'Resources/js/roles/editRole.js', 'public/js/roles');
mix.js(moduleDir + 'Resources/js/roles/listRoles.js', 'public/js/roles');
mix.sass(moduleDir + 'Resources/sass/roles/listRoles.scss', 'public/css/roles');
mix.js(moduleDir + 'Resources/js/roles/viewRole.js', 'public/js/roles');
mix.sass(moduleDir + 'Resources/sass/roles/viewRole.scss', 'public/css/roles');

/**
 * Users
 */
mix.js(moduleDir + 'Resources/js/users/addUser.js', 'public/js/users');
mix.sass(moduleDir + 'Resources/sass/users/addUser.scss', 'public/css/users');
mix.js(moduleDir + 'Resources/js/users/changeUserPassword.js', 'public/js/users');
mix.sass(moduleDir + 'Resources/sass/users/changeUserPassword.scss', 'public/css/users');
mix.js(moduleDir + 'Resources/js/users/editUser.js', 'public/js/users');
mix.sass(moduleDir + 'Resources/sass/users/editUser.scss', 'public/css/users');
mix.js(moduleDir + 'Resources/js/users/listUser.js', 'public/js/users');
mix.sass(moduleDir + 'Resources/sass/users/listUser.scss', 'public/css/users');
