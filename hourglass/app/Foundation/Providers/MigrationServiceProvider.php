<?php

namespace Hourglass\Foundation\Providers;

use Illuminate\Database\MigrationServiceProvider as BaseProvider;
use Hourglass\Foundation\Migration\DatabaseMigrationRepository;

class MigrationServiceProvider extends BaseProvider
{
    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function ($app) {
            $table = $app['config']['database.migrations'];

            return new DatabaseMigrationRepository($app['db'], $table);
        });
    }
}