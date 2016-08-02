<?php namespace Hourglass\Core\Config;

use Illuminate\Support\ServiceProvider;
use Hourglass\Core\File\FileLoader;
use Hourglass\Core\File\Filesystem;

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