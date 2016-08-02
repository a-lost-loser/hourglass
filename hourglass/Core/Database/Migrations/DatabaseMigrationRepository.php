<?php namespace Hourglass\Core\Database\Migrations;

use Hourglass\Core\Database\Schema\Blueprint;
use Hourglass\Core\Plugin\PluginManager;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Schema\Builder;
use App;
use DB;

class DatabaseMigrationRepository implements MigrationRepositoryInterface
{
    /**
     * The database connection resolver instance.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The name of the migration table.
     *
     * @var string
     */
    protected $migrationTable;

    /**
     * The name of the plugin list table.
     *
     * @var string
     */
    protected $pluginTable;

    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection;

    /**
     * DatabaseMigrationRepository constructor.
     * @param Resolver $resolver
     * @param string $migrationTable
     * @param string $pluginTable
     */
    public function __construct(Resolver $resolver, $migrationTable, $pluginTable)
    {
        $this->migrationTable = $migrationTable;
        $this->pluginTable = $pluginTable;
        $this->resolver = $resolver;
    }

    /**
     * Get the ran migrations for a given package.
     *
     * @return array
     */
    public function getRan()
    {
        return $this->table()->lists('migration');
    }

    /**
     * Get the last migration batch.
     *
     * @return array
     */
    public function getLast()
    {
        // Workaround so we can conform to the interface we implement
        $arguments = func_get_args();
        $plugin = isset($arguments[0]) ? $arguments[0] : 'Hourglass';

        $pluginId = DB::table($this->pluginTable)->where('identifier', '=', $plugin)->value('id');

        if (is_null($pluginId)) {
            return [];
        }

        $query = $this->table()->where('batch', $this->getLastBatchNumber())->where('plugin_id', $pluginId);

        return $query->orderBy('migration', 'desc')->get();
    }

    /**
     * Log that a migration was run.
     *
     * @param  string $file
     * @param  int $batch
     * @return void
     */
    public function log($file, $batch)
    {
        $pluginList = PluginManager::instance()->getPluginList();
        $path = dirname(dirname($file)); // Should be "files"

        $ranPlugin = '';
        foreach ($pluginList as $plugin) {
            if (realpath($plugin['paths']['files']) == realpath($path)) {
                // We have found the plugin that has run the migration
                $ranPlugin = $plugin['identifier'];
                break;
            }
        }

        // If no plugin has been found, it came from the Backend
        if ($ranPlugin == '')
            $ranPlugin = 'Hourglass';

        // Look up the plugin id from the plugin table
        $pluginId = DB::table($this->pluginTable)->where('identifier', '=', $ranPlugin)->value('id');

        // Finally, log that this migration did run
        DB::table($this->migrationTable)->insert([
            'migration' => basename($file),
            'batch' => $batch,
            'plugin_id' => $pluginId,
        ]);
    }

    /**
     * Remove a migration from the log.
     *
     * @param  object $migration
     * @return void
     */
    public function delete($migration)
    {
        $this->table()->where('migration', $migration->migration)->delete();
    }

    /**
     * Get the next migration batch number.
     *
     * @return int
     */
    public function getNextBatchNumber()
    {
        return $this->getLastBatchNumber() + 1;
    }

    public function getLastBatchNumber()
    {
        return $this->table()->max('batch');
    }

    /**
     * Create the migration repository data store.
     *
     * @return void
     */
    public function createRepository()
    {
        App::make(SetupMigrationRepository::class)->up();
    }

    /**
     * Determine if the migration repository exists.
     *
     * @return bool
     */
    public function repositoryExists()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        return $schema->hasTable($this->migrationTable) && $schema->hasTable($this->pluginTable);
    }

    /**
     * Set the information source to gather data.
     *
     * @param  string $name
     * @return void
     */
    public function setSource($name)
    {
        $this->connection = $name;
    }

    /**
     * Get a query builder for the migration table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->getConnection()->table($this->migrationTable);
    }

    /**
     * Get the connection resolver instance.
     *
     * @return Resolver
     */
    public function getConnectionResolver()
    {
        return $this->resolver;
    }

    /**
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return $this->resolver->connection($this->connection);
    }
}