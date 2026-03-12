<?php

namespace Modules\Gallery\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Gallery\Http\Controllers';

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
            ->group(module_path('Gallery', '/Routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->prefix('tracez-admin')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Gallery', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Gallery', '/Routes/api.php'));
    }
}
