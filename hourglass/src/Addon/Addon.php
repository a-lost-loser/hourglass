<?php

namespace Hourglass\Addon;

use Illuminate\Support\ServiceProvider;

abstract class Addon extends ServiceProvider
{
    public function enable()
    {
        $this->register();
    }

    public function register()
    {

    }
}