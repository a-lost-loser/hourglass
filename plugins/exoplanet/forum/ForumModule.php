<?php namespace Exoplanet\Forum;

use Exoplanet\Atmosphere\Plugin\ModuleBase;

class ForumModule extends ModuleBase
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__.'/files/routes.php';
    }

    public function boot()
    {

    }
}