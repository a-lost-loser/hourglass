<?php

namespace Hourglass\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->addViewNamespaces();
        $this->addBladeDirectives();
    }

    protected function addViewNamespaces()
    {
        $this->loadViewsFrom(base_path('hourglass/resources/views'), 'Hourglass');
    }

    protected function addBladeDirectives()
    {

    }
}
