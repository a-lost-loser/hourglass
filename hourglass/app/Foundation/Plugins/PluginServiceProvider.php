<?php

namespace Hourglass\Foundation\Plugins;

use Composer\Autoload\ClassLoader;
use Composer\Package\Loader\ArrayLoader;
use Composer\Package\Loader\JsonLoader;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->addNamespaces();
    }

    protected function addNamespaces()
    {
        /** @var ClassLoader $autoloader */
        $autoloader = require base_path('vendor/autoload.php');

        $discoverer = new Discoverer(base_path('plugins'));
        $discoveries = $discoverer->discover();

        $discoveries->each->registerAutoloaders($autoloader);
    }
}