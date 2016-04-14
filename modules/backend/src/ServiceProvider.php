<?php namespace Communalizer\Backend;

use Illuminate\Support\ServiceProvider as ServiceProviderBase;
use View;

class ServiceProvider extends ServiceProviderBase
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register backend routes
        $this->registerRoutes();
        $this->registerViewNamespace();
    }

    public function boot()
    {

    }

    protected function registerRoutes()
    {
        require __DIR__.'/../files/routes.php';
    }

    protected function registerViewNamespace()
    {
        View::addNamespace('Backend', __DIR__.'/../files/resources/views');
    }
}