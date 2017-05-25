<?php

namespace Hourglass\Foundation\Plugins;

use Illuminate\Support\ServiceProvider;

abstract class Plugin extends ServiceProvider
{
    public function boot()
    {
        // Map routes defined by the plugin
        if (method_exists($this, 'mapRoutes')) {
            $this->app->call([$this, 'mapRoutes']);
        }

        // Add views
        if (method_exists($this, 'mapViews')) {
            $this->app->call([$this, 'mapViews']);
        }
    }

    public function register()
    {
        // ...
    }

    public final function canBeEnabled()
    {
        return true;
    }
}