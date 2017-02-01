<?php

namespace Hourglass\Foundation\Testing\Dusk;

use Laravel\Dusk\DuskServiceProvider as LaravelDuskServiceProvider;

class DuskServiceProvider extends LaravelDuskServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\DuskCommand::class,
            ]);
        }
    }
}
