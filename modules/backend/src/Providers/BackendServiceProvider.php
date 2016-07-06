<?php namespace Communalizer\Backend\Providers;

use Illuminate\Support\ServiceProvider as ServiceProviderBase;
use View;

class BackendServiceProvider extends ServiceProviderBase
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
        require $this->basePath('files/routes.php');
    }

    protected function registerViewNamespace()
    {
        View::addNamespace('Backend', $this->basePath('files/resources/views'));
    }

    protected function basePath($file)
    {
        $postfix = '/' . ltrim($file, '/');
        return base_path('modules/backend' . $postfix);
    }
}