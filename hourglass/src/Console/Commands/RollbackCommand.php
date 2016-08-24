<?php

namespace Hourglass\Console\Commands;

use Hourglass\Database\Migrator;
use Illuminate\Database\Console\Migrations\RollbackCommand as BaseCommand;

class RollbackCommand extends BaseCommand
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