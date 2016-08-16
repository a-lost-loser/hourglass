<?php namespace Hourglass\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ApplicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group([], function ($app) {
            require __DIR__.'/../../routes.php';
        });
    }
}