<?php

namespace Hourglass\Addon;

use Illuminate\Contracts\Foundation\Application;

class AddonRepository
{
    protected $enabledAddons = [];

    protected $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function getInstalledAddonList()
    {
        $path = base_path('addons');

        $addonNames = [];

        return collect($addonNames);
    }

    public function enableAddon($addon)
    {
        $object = $addon;

        if (is_string($addon) && class_exists($addon)) {
            $object = new $addon($this->app);
        }

        $object->enable();
        $this->enabledAddons[get_class($object)] = $object;

        return $object;
    }

    public function isEnabled($name)
    {
        return array_key_exists($name, $this->enabledAddons);
    }
}