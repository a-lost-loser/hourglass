<?php namespace Hourglass\Addon;

use Hourglass\Exception\AddonLoadingFailedException;
use Hourglass\Parse\Yaml;
use Hourglass\Support\Facades\File;
use Illuminate\Container\Container;

class AddonRepository
{
    protected $application;

    protected $addons = [];

    public function __construct(Container $app)
    {
        $this->application = $app;
    }

    public function loadAddons()
    {
        foreach ($this->getAddonFolders() as $name) {
            try {
                $addon = $this->loadAddon($name);
                $this->addons[] = $addon;
                $addon->register();
            } catch (AddonLoadingFailedException $e) {
                // Logging
                continue;
            }
        }
    }

    protected function loadAddon($name)
    {
        if (!($config = $this->loadConfiguration($name))) {
            throw new AddonLoadingFailedException('Addon configuration could not be loaded for addon ' . $name);
        }

        if ($config->get('composer.type') != 'hourglass-addon') {
            throw new AddonLoadingFailedException('Addon type is expected to be "hourglass-addon" for addon ' . $name);
        }

        if (!($psr4 = $config->get('composer.autoload.psr-4'))) {
            throw new AddonLoadingFailedException('Could not find PSR-4 autoloading expression in composer.json for addon ' . $name);
        }

        $baseClass = $config->get('yaml.base.class', array_keys($psr4)[0] . 'Addon');
        if (!class_exists($baseClass)) {
            throw new AddonLoadingFailedException('Base class "'.$baseClass.'" could not be found for addon ' . $name);
        }

        $addon = new $baseClass($this->application, $config);
        return $addon;
    }

    protected function getAddonFolders()
    {
        return array_map(function ($path) {
            return basename($path);
        }, File::directories(base_path('addons')));
    }

    protected function loadConfiguration($name)
    {
        $composerPath = base_path("addons/$name/composer.json");
        $yamlPath = base_path("addons/$name/addon.yaml");

        if (!File::exists($composerPath)) {
            return false;
        }

        $composer = File::get($composerPath);
        $yaml = File::exists($yamlPath) ? File::get($yamlPath) : '';

        $composer = json_decode($composer, true);
        $yaml = (new Yaml)->parse($yaml);

        return new AddonConfiguration($composer, $yaml);
    }

    public function all()
    {
        return $this->addons;
    }
}