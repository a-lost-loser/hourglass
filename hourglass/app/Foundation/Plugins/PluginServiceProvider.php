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
        $this->repository->register();

        $this->app->singleton(PluginRepository::class, function () use ($repository) {
            return $repository;
        });
    }

    public function provides()
    {
        return [ PluginRepository::class ];
    }
}