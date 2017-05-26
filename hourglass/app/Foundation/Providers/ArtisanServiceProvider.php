<?php

namespace Hourglass\Foundation\Providers;

use Hourglass\Foundation\Migration\Commands\MigrateCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as BaseServiceProvider;

class ArtisanServiceProvider extends BaseServiceProvider
{
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });
    }
}