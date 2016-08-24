<?php

namespace Hourglass\Console\Commands;

use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Hourglass\Database\Migrator;

class MigrateCommand extends BaseMigrateCommand
{
    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);
    }

    protected function getMigrationPath()
    {
        return base_path('hourglass/database/migrations');
    }
}