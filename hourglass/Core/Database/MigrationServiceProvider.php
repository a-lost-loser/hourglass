<?php namespace Hourglass\Core\Database;

use Hourglass\Core\Database\Console\Migrations\InstallCommand;
use Hourglass\Core\Database\Console\Migrations\MigrateCommand;
use Hourglass\Core\Database\Console\Migrations\RollbackCommand;
use Hourglass\Core\Database\Migrations\DatabaseMigrationRepository;
use Hourglass\Core\Database\Migrations\Migrator;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();

        $this->registerMigrator();

        $this->registerCreator();

        $this->registerCommands();
    }

    public function provides()
    {
        return [
            'migrator', 'migration.repository', 'command.migrate',
            'command.migrate.install', 'command.migrate.rollback',
        ];
    }

    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function($app) {
            $migrationTable = $app['config']['database.migrations'];
            $pluginTable = $app['config']['database.plugins'];

            return new DatabaseMigrationRepository($app['db'], $migrationTable, $pluginTable);
        });
    }

    protected function registerMigrator()
    {
        $this->app->singleton('migrator', function($app) {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files']);
        });
    }

    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function($app) {
            return new MigrationCreator($app['files']);
        });
    }

    protected function registerCommands()
    {
        $commands = ['Migrate', 'Install', 'Rollback'];

        foreach ($commands as $command) {
            $this->{'register'.$command.'Command'}();
        }

        $this->commands(
            'command.migrate',
            'command.migrate.install',
            'command.migrate.rollback'
        );
    }

    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function($app) {
            return new MigrateCommand($app['migrator']);
        });
    }

    protected function registerInstallCommand()
    {
        $this->app->singleton('command.migrate.install', function($app) {
            return new InstallCommand($app['migration.repository']);
        });
    }

    protected function registerRollbackCommand()
    {
        $this->app->singleton('command.migrate.rollback', function($app) {
            return new RollbackCommand($app['migrator']);
        });
    }
}