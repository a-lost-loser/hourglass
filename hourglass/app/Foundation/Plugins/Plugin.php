<?php

namespace Hourglass\Foundation\Plugins;

use Illuminate\Support\ServiceProvider;

abstract class Plugin extends ServiceProvider
{
    /**
     * @var string
     */
    protected $configurationPath = '';

    public function register()
    {
        // ...
    }

    public final function canBeEnabled()
    {
        return true;
    }
}