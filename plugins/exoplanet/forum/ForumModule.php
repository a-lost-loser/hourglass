<?php namespace Exoplanet\Forum;

use Exoplanet\Atmosphere\Plugin\ModuleBase;
use TemplateResolver;
use View;

class ForumModule extends ModuleBase
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->includeRoutes();
        $this->includeViews();

        TemplateResolver::addEvent('Exoplanet.Backend:testing', 'main', $this);
    }
}