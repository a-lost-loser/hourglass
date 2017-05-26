<?php

namespace Hourglass\Foundation\Migration;

use Illuminate\Database\Migrations\DatabaseMigrationRepository as BaseMigrationRepository;

class DatabaseMigrationRepository extends BaseMigrationRepository
{
    /**
     * Log that a migration was run.
     *
     * @param  string  $file
     * @param  int     $batch
     * @return void
     */
    public function log($file, $batch)
    {
        $plugin = func_get_arg(2);
        $record = ['migration' => $file, 'batch' => $batch, 'plugin' => $plugin ? $plugin : 'hourglass/hourglass'];

        $this->table()->insert($record);
    }

    /**
     * Create the migration repository data store.
     *
     * @return void
     */
    public function createRepository()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        $schema->create($this->table, function ($table) {
            // The migrations table is responsible for keeping track of which of the
            // migrations have actually run for the application. We'll create the
            // table to hold the migration file's path as well as the batch ID.
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
            $table->string('plugin');
        });
    }
}