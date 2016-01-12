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
        PluginManager::instance()->registerAll();
    }

    public function boot()
    {
        PluginManager::instance()->bootAll();
    }
}