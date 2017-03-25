<?php

namespace Hourglass\Foundation\Plugins;

use Composer\Autoload\ClassLoader;
use Composer\Package\PackageInterface;

class DiscoveredPlugin
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var PackageInterface
     */
    private $package;

    /**
     * DiscoveredPlugin constructor.
     *
     * @param $path
     * @param PackageInterface $package
     */
    public function __construct($path, PackageInterface $package)
    {
        $this->path = $path;
        $this->package = $package;
    }

    /**
     * Registers all autoloaders specified in the package with the given class loader
     *
     * @param ClassLoader $autoloader
     */
    public function registerAutoloaders(ClassLoader $autoloader)
    {
        $autoloaders = $this->package->getAutoload();

        foreach ($autoloaders as $type => $value) {
            $method = camel_case('register-'.$type);
            call_user_func([$this, $method], $autoloader, $value);
        }
    }

    /**
     * Registers the given classmaps
     *
     * @param ClassLoader $autoloader
     * @param $value
     */
    protected function registerClassmap(ClassLoader $autoloader, $value)
    {
        $values = collect($value)->map(function ($classmap) {
            return $this->path . DIRECTORY_SEPARATOR . $classmap;
        });

        $autoloader->addClassMap($values->toArray());
    }

    /**
     * Registers the given PSR-4 autoloaders
     *
     * @param ClassLoader $autoloader
     * @param $value
     */
    protected function registerPsr4(ClassLoader $autoloader, $value)
    {
        collect($value)->each(function ($item, $key) use ($autoloader) {
            $autoloader->addPsr4($key, $this->path . DIRECTORY_SEPARATOR . $item);
        });
    }

    /**
     * Registers the given PSR-0 autoloaders
     *
     * @param ClassLoader $autoloader
     * @param $value
     */
    protected function registerPsr0(ClassLoader $autoloader, $value)
    {
        collect($value)->each(function ($item, $key) use ($autoloader) {
            $autoloader->add($key, $this->path . DIRECTORY_SEPARATOR . $item);
        });
    }
}