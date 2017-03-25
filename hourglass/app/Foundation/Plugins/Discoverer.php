<?php

namespace Hourglass\Foundation\Plugins;

use Composer\Package\Loader\ArrayLoader;
use Composer\Package\Loader\JsonLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class Discoverer
{
    /**
     * @var string
     */
    private $path;

    /**
     * Discoverer constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Returns a list of paths with potential plugins
     *
     * @return Collection
     */
    public function discover()
    {
        $plugins = [];
        $filesystem = new Filesystem;

        // Create a list of all directories within the plugins folder
        $namespaces = collect($filesystem->directories($this->path));
        $namespaces->each(function ($namespace) use (&$plugins, $filesystem) {
            $plugins = array_merge($plugins, $filesystem->directories($namespace));
        });

        // Convert plugins array to collection and omit all directories without a valid composer.json
        $plugins = collect($plugins);
        $plugins = $plugins->map(function ($plugin) {
            try {
                $loader = new JsonLoader(new ArrayLoader);
                $package = $loader->load($plugin.DIRECTORY_SEPARATOR.'composer.json');

                return new DiscoveredPlugin($plugin, $package);
            } catch (\UnexpectedValueException $e) {
                return null;
            }
        })->filter();

        return $plugins;
    }
}