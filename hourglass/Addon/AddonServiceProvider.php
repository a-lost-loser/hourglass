<?php namespace Hourglass\Addon;

use Hourglass\Addon\Facades\Addons;
use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('addons.repository', function ($app) {
            return new AddonRepository($app);
        });

        Addons::loadAddons();
    }
}