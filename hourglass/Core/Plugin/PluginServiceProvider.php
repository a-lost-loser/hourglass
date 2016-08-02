<?php namespace Hourglass\Core\Plugin;

use Illuminate\Support\ServiceProvider;
use Hourglass\Core\Plugin\Console\InstallCommand;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();

        PluginRepository::instance();
        PluginManager::instance()->registerAll();
    }

    public function boot()
    {
        PluginManager::instance()->bootAll();
    }

    /**
     * Registers the commands this service provider provides.
     */
    public function registerCommands()
    {
        $this->commands([
            'command.plugin.install',
        ]);

        $this->app->singleton('command.plugin.install', function($app) {
            return new InstallCommand();
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'command.plugin.install',
        ];
    }
}