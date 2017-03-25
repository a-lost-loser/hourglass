<?php

namespace Hourglass\Foundation\Bootstrap;

use Hourglass\Foundation\Application;

class RegisterPlugins
{
    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredPlugins();
    }
}
