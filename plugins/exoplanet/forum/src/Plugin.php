<?php namespace Exoplanet\Forum;

use Exoplanet\Atmosphere\Plugin\PluginBase;
use TemplateResolver;

class Plugin extends PluginBase
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        TemplateResolver::addEvent($this, 'Exoplanet.Backend:testing', 'main');
    }
}