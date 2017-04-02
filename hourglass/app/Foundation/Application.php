<?php

namespace Hourglass\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{

    /**
     * Register all of the configured plugins.
     *
     * @return void
     */
    public function registerConfiguredPlugins()
    {
        //(new PluginRepository($this, new Filesystem, $this->getCachedPluginsPath()))
        //    ->load($this->config['app.providers']);
    }

    /**
     * Get the path to the cached plugins.php file.
     *
     * @return string
     */
    public function getCachedPluginsPath()
    {
        return $this->bootstrapPath().'/cache/plugins.php';
    }
}