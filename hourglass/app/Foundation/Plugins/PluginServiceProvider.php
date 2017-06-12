<?php

namespace Hourglass\Foundation\Plugins;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * @var PluginRepository
     */
    protected $repository;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->repository->boot();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $repository = $this->repository = new PluginRepository($this->app);

        $this->app->singleton(PluginRepository::class, function () use ($repository) {
            return $repository;
        });

        // We do not want to automatically register any plugins in the testing environment
        if ($this->app->environment() == 'testing')
            return;

        $this->repository->register();
    }

    public function provides()
    {
        return [ PluginRepository::class ];
    }
}