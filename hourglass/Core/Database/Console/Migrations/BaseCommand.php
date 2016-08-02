<?php namespace Hourglass\Core\Database\Console\Migrations;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * Get the paths to the migration directories.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return base_path('modules/backend/files/migrations');
    }
}