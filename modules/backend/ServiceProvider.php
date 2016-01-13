<?php namespace Surgeon\Board\Backend;

use Illuminate\Support\ServiceProvider as ServiceProviderBase;
use Surgeon\Nurse\Plugin\PluginManager;

class ServiceProvider extends ServiceProviderBase
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register all plugins
        PluginManager::instance()->registerAll();

        // Register backend routes
        $this->registerRoutes();

    }

    public function boot()
    {
        PluginManager::instance()->bootAll();
    }

    protected function registerRoutes()
    {
        require __DIR__.'/files/routes.php';
    }
}