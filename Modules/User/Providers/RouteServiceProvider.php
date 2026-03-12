<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\User\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapAdminRoutes();

        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }


    protected function mapWebRoutes()
    {
        Route::middleware('web')->prefix('user')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')->prefix('elegant-admin')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/api.php'));
    }
}
