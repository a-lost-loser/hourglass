<?php namespace Hourglass\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ApplicationServiceProvider extends AggregateServiceProvider
{
    public function register()
    {
        $this->registerRoutes();
        $this->registerViews();
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