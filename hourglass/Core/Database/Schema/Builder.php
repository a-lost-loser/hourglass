<?php namespace Hourglass\Core\Database\Schema;

use Hourglass\Core\Database\Connections\Connection;
use Illuminate\Database\Schema\Builder as BuilderBase;

class Builder extends BuilderBase
{
    /**
     * The database connection instance.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * Create a new database Schema manager.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->grammar = $connection->getSchemaGrammar();
    }
}