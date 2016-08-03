<?php namespace Hourglass\Database\Connectors;

use PDO;
use InvalidArgumentException;
use Hourglass\Database\Connections\MySqlConnection;
use Hourglass\Database\Connections\SQLiteConnection;
use Hourglass\Database\Connections\PostgresConnection;
use Hourglass\Database\Connections\SqlServerConnection;
use Illuminate\Database\Connectors\ConnectionFactory as ConnectionFactoryBase;

class ConnectionFactory extends ConnectionFactoryBase
{
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($this->container->bound($key = "db.connection.{$driver}")) {
            return $this->container->make($key, [$connection, $database, $prefix, $config]);
        }

        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);

            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);

            case 'sqlite':
                return new SQLiteConnection($connection, $database, $prefix, $config);

            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }

        throw new InvalidArgumentException("Unsupported driver [$driver]");
    }
}