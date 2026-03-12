<?php

namespace Modules\Cms\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Cms\Http\Controllers';


    public function boot(): void
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cms', '/Routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->prefix('elegant-admin')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cms', '/Routes/admin.php'));
    }
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cms', '/Routes/api.php'));
    }

}
