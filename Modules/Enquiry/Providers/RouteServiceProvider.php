<?php

namespace Modules\Enquiry\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Enquiry\Http\Controllers';

    public function boot(): void
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(module_path('Enquiry', '/Routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->prefix('elegant-admin')
            ->namespace($this->namespace)
            ->group(module_path('Enquiry', '/Routes/admin.php'));
    }
}
