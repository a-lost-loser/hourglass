<?php

namespace Hourglass\Foundation\Plugins;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * A list of all discovered plugins
     *
     * @var array
     */
    protected $plugins = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Boot all registered plugins sorted by their priority
        collect($this->plugins)
            ->sortBy('priority')
            ->each(function ($plugin) {
                if ($plugin['enabled']) {
                    $plugin['object']->boot();
                }
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAllPlugins();
    }

    /**
     * Locates, instantiates and registers all available plugins.
     *
     * @return void
     */
    protected function registerAllPlugins()
    {
        /** @var \Composer\Autoload\ClassLoader $autoloader */
        $autoloader = require base_path('vendor/autoload.php');

        // Discover installed plugins
        $discoverer = new Discoverer(base_path('plugins'));
        $discoveries = $discoverer->discover();

        // Register the autoloader of each plugin
        $discoveries->each->registerAutoloaders($autoloader);

        // Instantiate every plugin and register it if possible
        $discoveries->each(function ($element) {
            $this->registerPlugin($element);
        });
    }

    /**
     * Instantiates and registers a given plugin after it has been discovered.
     *
     * @param DiscoveredPlugin $plugin
     * @return void
     */
    protected function registerPlugin(DiscoveredPlugin $plugin)
    {
        $data = [
            'name' => $plugin->getIdentifier(),
            'path' => $plugin->getEntryClass(),
            'priority' => $plugin->getBootPriority(),
            'enabled' => false,
        ];

        $entry = $plugin->getEntryClass();
        if (!$entry)
            $data['error'] = 'missing entry class';
        elseif (!is_a($entry, Plugin::class, true))
            $data['error'] = 'entry class isn\'t a plugin';
        else {
            /** @var Plugin $class */
            $class = new $entry($this->app);

            if ($class->canBeEnabled()) {
                $class->register();

                $data['enabled'] = true;
                $data['object'] = $class;
            }
        }

        $this->plugins[] = $data;
    }
}