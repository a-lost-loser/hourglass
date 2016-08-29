<?php

namespace Hourglass\Providers;

use Illuminate\Support\ServiceProvider;
use Hourglass\Addon\AddonRepository;

class AddonSupportServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AddonRepository::class, function ($app) {
            return new AddonRepository($app);
        });

        $this->enableAddons();
    }

    protected function enableAddons()
    {
        $app = $this->app;

        $repository = $this->app->make(AddonRepository::class);
        $repository->getInstalledAddonList()->each(function ($name) use ($app) {
            $addon = new $name($app);
            $addon->enable();
        });
    }
}