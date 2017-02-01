<?php namespace Hourglass\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Hourglass\Foundation\Testing\Dusk\DuskServiceProvider;

class ApplicationServiceProvider extends AggregateServiceProvider
{
    public function register()
    {
        $this->registerTestingServiceProviders();

        $this->registerRoutes();
        $this->registerViews();
    }

    protected function registerTestingServiceProviders()
    {
        if (!$this->app->environment('local', 'testing')) return;

        $this->app->register(DuskServiceProvider::class);
    }

    protected function registerRoutes()
    {
        Route::group([], function () {
            require __DIR__.'/../../routes.php';
        });
    }

    protected function registerViews()
    {
        View::addNamespace('Hourglass.Backend', base_path('hourglass/resources/views'));
    }
}
