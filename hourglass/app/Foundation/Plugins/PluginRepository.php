<?php

namespace Hourglass\Foundation\Plugins;

use Illuminate\Support\Collection;

final class PluginRepository
{
    const NO_ERROR = 0;

    const ERROR_ENTRY_MISSING = 1;

    const ERROR_ENTRY_NOT_A_PLUGIN = 2;

    /**
     * @var Collection
     */
    protected $discoveredPlugins;

    protected $registered = false;

    protected $booted = false;

    protected $app;

    /**
     * Create a new plugin repository instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Returns if the given plugin could be discovered.
     *
     * @param   string  $name
     * @return  bool
     */
    public function wasDiscovered($name)
    {
        return $this->discoveredPlugins->contains(function ($plugin) use ($name) {
            return $plugin['identifier'] == $name;
        });
    }

    /**
     * Returns the error of a given plugin, if any.
     *
     * @param   string  $name
     * @return  int|bool
     */
    public function getError($name)
    {
        if (!$this->wasDiscovered($name)) return null;

        return $this->discoveredPlugins
            ->where('identifier', $name)
            ->first()['error'];
    }

    /**
     * Returns the path to the given plugin or null if it's not installed.
     *
     * @param   string  $name
     * @return  string|null
     */
    public function getPath($name)
    {
        if (!$this->wasDiscovered($name)) return null;

        return $this->discoveredPlugins
            ->where('identifier', $name)
            ->first()['discovery']
            ->getPath();
    }

    /**
     * Instantiates and registers all plugins that can be enabled. Will only be executed once.
     *
     * @return void
     */
    public function register()
    {
        if ($this->registered) return;
        $this->registered = true;

        $plugins = $this->discover();
        $this->registerAutoloaders($plugins);

        $this->discoveredPlugins = $plugins->map(function ($plugin) {
            $map = [
                'identifier' => $plugin->getIdentifier(),
                'discovery' => $plugin,
                'enabled' => false,
                'error' => self::NO_ERROR,
            ];

            $entry = $plugin->getEntryClass();
            if (!$entry) $map['error'] = self::ERROR_ENTRY_MISSING;
            elseif (!is_a($entry, Plugin::class, true)) $map['error'] = self::ERROR_ENTRY_NOT_A_PLUGIN;

            if ($map['error']) return $map;

            $class = new $entry($this->app);
            if ($class->canBeEnabled()) {
                $class->register();

                $map['enabled'] = true;
                $map['object'] = $class;
            }

            return $map;
        })->sortBy(function ($plugin) {
            return $plugin['discovery']->getBootPriority();
        });
    }

    /**
     * Discovers all plugins within the plugin path.
     *
     * @return Collection
     */
    protected function discover()
    {
        // Discover installed plugins
        $discoverer = new Discoverer(config('app.plugin_path'));
        $discoveries = $discoverer->discover();

        return $discoveries;
    }

    /**
     * Registers all autoloaders of the given plugins.
     *
     * @param $plugins
     */
    protected function registerAutoloaders($plugins)
    {
        /** @var \Composer\Autoload\ClassLoader $autoloader */
        $autoloader = require base_path('vendor/autoload.php');

        $plugins->each->registerAutoloaders($autoloader);
    }

    /**
     * Boots all plugins that are registered. Will only be executed once.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->registered) return;

        // Boot all registered plugins sorted by their priority
        $this->discoveredPlugins
            ->each(function ($plugin) {
                if ($plugin['enabled']) {
                    $plugin['object']->boot();
                }
            });
    }
}