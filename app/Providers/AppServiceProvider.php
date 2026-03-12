<?php

namespace App\Providers;

use App\Events\EnquiryReceived;
use App\Listeners\HandleEnquiry;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Lesson\Component\Row;
use App\View\Components\Lesson\Component\Column;
use App\View\Components\Lesson\Component\Modal;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('lesson-component-row', Row::class);
        Blade::component('lesson-component-column', Column::class);
        Blade::component('lesson-component-modal', Modal::class);
        Schema::defaultStringLength(191);

        Event::listen(
            EnquiryReceived::class,
            HandleEnquiry::class,
        );
    }
}
