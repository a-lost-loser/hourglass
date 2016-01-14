<?php namespace Surgeon\Demo;

use Exoplanet\Atmosphere\Plugin\PluginBase;

class Plugin extends PluginBase {

    public function register()
    {
        require __DIR__.'/files/routes.php';
    }

}