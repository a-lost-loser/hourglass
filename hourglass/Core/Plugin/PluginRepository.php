<?php namespace Hourglass\Core\Plugin;

use Hourglass\Core\Support\Traits\Singleton;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Exception;
use File;

class PluginRepository
{

    /**
     * Just a stub for now.
     *
     * Plugins are to be registered from the PluginServiceProvider, which itself
     * is the very last of the application's Service Providers to be registered.
     *
     * The Service Provider will later on be responsible for registering and booting
     * plugins, making the PluginManager singleton obsolete. To access a list of the
     * available and running plugins, this class has been created and will store
     * information about all plugins known to the system.
     */

    use Singleton;

    protected $pathList = [];

    protected $pluginList = [];

    protected function init()
    {
        $this->pathList = $this->getPluginPaths();
    }

    /**
     * Gets the path to all plugins inside the application's plugin directory.
     *
     * @return array
     * @throws Exception
     */
    protected function getPluginPaths()
    {
        $paths = [];
        $dirPath = plugins_path();

        if (!File::isDirectory($dirPath)) {
            throw new Exception("The plugin directory $dirPath does not exist.");
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirPath));
        $iterator->setMaxDepth(2);
        $iterator->rewind();

        while ($iterator->valid()) {
            if (($iterator->getDepth() > 1) && $iterator->isFile() && (strtolower($iterator->getFilename()) == 'plugin.yaml')) {
                $yamlPath = dirname($iterator->getPathname());
                $pluginName = basename($yamlPath);
                $vendorName = basename(dirname($yamlPath));

                $paths = [
                    'vendor' => $vendorName,
                    'plugin' => $pluginName,
                    'path'   => $yamlPath,
                ];
            }

            $iterator->next();
        }

        return $paths;
    }

}