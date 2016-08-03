<?php namespace Hourglass\Database\Migrations;

use Illuminate\Database\Migrations\Migrator as MigratorBase;

class Migrator extends MigratorBase
{
    /**
     * @var string
     */
    protected $lastMigratedPath = '';

    /**
     * Run the outstanding migrations at a given path.
     *
     * @param  string  $path
     * @param  array   $options
     * @return void
     */
    public function run($path, array $options = [])
    {
        $this->notes = [];

        $this->lastMigratedPath = $path;
        $files = $this->getMigrationFiles($path);

        // Once we grab all of the migration files for the path, we will compare them
        // against the migrations that have already been run for this package then
        // run each of the outstanding migrations against a database connection.
        $ran = $this->repository->getRan();

        $migrations = array_diff($files, $ran);

        $this->requireFiles($path, $migrations);

        $this->runMigrationList($migrations, $options);
    }

    /**
     * Run "up" a migration instance.
     *
     * @param  string  $file
     * @param  int     $batch
     * @param  bool    $pretend
     * @return void
     */
    protected function runUp($file, $batch, $pretend)
    {
        // First we will resolve a "real" instance of the migration class from this
        // migration file name. Once we have the instances we can run the actual
        // command such as "up" or "down", or we can just simulate the action.
        $migration = $this->resolve($file);


        if ($pretend) {
            return $this->pretendToRun($migration, 'up');
        }

        $migration->up();

        // Once we have run a migrations class, we will log that it was run in this
        // repository so that we don't try to run it next time we do a migration
        // in the application. A migration repository keeps the migrate order.
        $this->repository->log($this->lastMigratedPath . '/' . $file, $batch);

        $this->note("<info>Migrated:</info> $file");
    }

    public function rollback($pretend = false)
    {
        // Workaround so we can conform to the class we inherit
        $arguments = func_get_args();
        $plugin = isset($arguments[1]) ? $arguments[1] : 'Hourglass';

        $this->notes = [];

        $migrations = $this->repository->getLast($plugin);

        $count = count($migrations);

        if ($count == 0) {
            $this->note('<info>Nothing to rollback.</info>');
        } else {
            foreach ($migrations as $migration) {
                $this->runDown((object) $migration, $pretend);
            }
        }

        return $count;
    }
}