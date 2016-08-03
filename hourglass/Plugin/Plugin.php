<?php namespace Hourglass\Plugin;

use Hourglass\Database\Migrations\Migrator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Route;
use SystemException;
use Schema;
use Yaml;
use View;
use File;
use Log;
use DB;

abstract class Plugin extends ServiceProvider
{
    /**
     * @var PluginConfiguration
     */
    public $configuration;

    /**
     * The dependencies of this plugin.
     *
     * @var array
     */
    public $require = [];

    /**
     * Determines if this plugin should have elevated privileges.
     *
     * @var bool
     */
    public $elevated = false;

    /**
     * Determines if this plugin should be loaded or not.
     *
     * @var bool
     */
    public $disabled = false;

    /**
     * PluginBase constructor.
     * @param Application $app
     * @param PluginConfiguration $configuration
     */
    public function __construct(Application $app, PluginConfiguration $configuration)
    {
        parent::__construct($app);

        $this->configuration = $configuration;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->isInstalled()) {
            Log::info("The plugin {$this->getIdentifier()} is currently not installed.");
            return;
        }

        if (!$this->isMigrated()) {
            Log::info("The plugin {$this->getIdentifier()} has migrations that need to be run.");
            return;
        }

        $this->includeViews();
        $this->includeRoutes();
    }

    /**
     * Installs this plugin by adding it to the plugins table.
     *
     * @return void
     */
    public final function installPlugin()
    {
        $pluginTable = $this->app['config']['database.plugins'];

        DB::table($pluginTable)->insert(
            [
                'identifier' => $this->getIdentifier(),
                'path' => $this->getPluginPath(),
                'version' => $this->configuration->get('plugin.version'),
                'is_enabled' => true,
                'created_at' => time(),
                'updated_at' => time(),
            ]
        );
    }

    /**
     * Determine whether this plugin is installed or not.
     *
     * @return bool
     */
    public function isInstalled()
    {
        $pluginTable = $this->app['config']['database.plugins'];

        if (!$this->app['migration.repository']->repositoryExists()) {
            $this->app['migration.repository']->createRepository();
        }

        return DB::table($pluginTable)->where('identifier', '=', $this->getIdentifier())->exists();
    }

    /**
     * Migrate this plugin.
     *
     * @return void
     */
    public final function migratePlugin()
    {
        /**
         * @var Migrator
         */
        $migrator = $this->app['migrator'];
        $filesPath = $this->configuration->get('base.files-dir');
        $migrator->run($this->getPluginPath($filesPath . 'migrations'));
    }

    /**
     * Determine whether the plugin has any migrations that need to be run.
     *
     * @return bool
     */
    public final function isMigrated()
    {
        $pluginPath = $this->getPluginPath();
        $filesPath  = $pluginPath . $this->configuration->get('base.files-dir');
        $filesPath .= 'migrations';

        if (!File::isDirectory($filesPath)) {
            // The migrations folder doesn't exist
            return true;
        }

        $files = File::allFiles($filesPath);
        if (count($files) == 0) {
            // There are no migrations to be run
            return true;
        }

        $files = array_map(function ($element) {
            return str_replace('.php', '', $element->getFileName());
        }, $files);

        $diff = array_diff($files, $this->app['migration.repository']->getRan());

        return count($diff) == 0;
    }

    /**
     * Gets the identifier of this plugin.
     *
     * @return string
     */
    public final function getIdentifier()
    {
        $parts = explode('\\', get_class($this));

        return $parts[0] . '.' . $parts[1];
    }

    /**
     * Gets the namespace of this plugin.
     *
     * @return string
     */
    public final function getNamespace()
    {
        $parts = explode('\\', get_class($this));

        return $parts[0] . '\\' . $parts[1] . '\\';
    }

    /**
     * Gets the plugin's path and optionally appends a path component.
     *
     * @param string $path
     * @return string
     */
    public function getPluginPath($path = '')
    {
        return PluginManager::instance()->getPluginPath($this->getIdentifier()) . '/' . $path;
    }

    /**
     * Gets the list of assets for this plugin.
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->configuration->get('plugin.assets');
    }

    /**
     * The namespace to be appended after the plugin's namespace that is used for route controllers
     *
     * @var string
     */
    protected $routeNamespace = 'Http\Controllers';

    /**
     * Includes optional routes for the plugin.
     *
     * @return void
     */
    protected final function includeRoutes()
    {
        $plugin = $this;

        Route::group(['namespace' => $this->getNamespace() . $this->routeNamespace], function () use ($plugin) {
            $plugin->routes();
        });
    }

    protected function routes()
    {
        // Do nothing
    }

    /**
     * Includes optional views for the plugin.
     *
     * @return void
     */
    protected final function includeViews()
    {
        $filesPath = $this->configuration->get('base.files-dir');
        $path = $this->getPluginPath($filesPath . 'resources/views');
        if (File::isDirectory($path)) {
            View::addNamespace($this->getIdentifier(), $path);
        }
    }
}