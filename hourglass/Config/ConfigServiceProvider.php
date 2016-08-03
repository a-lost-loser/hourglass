<?php namespace Hourglass\Config;

use Illuminate\Support\ServiceProvider;
use Hourglass\File\FileLoader;
use Hourglass\File\Filesystem;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('config', function ($app) {
            return new Repository($this->getConfigLoader(), $app['env']);
        }, true);
    }

    public function provides()
    {
        return ['config'];
    }

    public function getConfigLoader()
    {
        return new FileLoader(new Filesystem, dirname($this->app['path']).'/config');
    }
}