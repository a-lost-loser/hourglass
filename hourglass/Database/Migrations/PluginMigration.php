<?php namespace Hourglass\Database\Migrations;


abstract class PluginMigration
{
    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection;

    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public abstract function getPluginIdentifier();

    public abstract function up();

    public abstract function down();
}