<?php namespace Hourglass\Core\Database;

use Hourglass\Core\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager as DatabaseManagerBase;

class DatabaseManager extends DatabaseManagerBase
{
    /**
     * Create a new database manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Hourglass\Core\Database\Connectors\ConnectionFactory  $factory
     */
    public function __construct($app, ConnectionFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }
}