<?php

namespace Hourglass\Foundation\Testing;

use Illuminate\Contracts\Console\Kernel;
use Hourglass\Addon\AddonRepository;

trait CreatesApplication
{
    public function createApplication()
    {
       $app = require __DIR__.'/../../../../bootstrap/app.php';

       $app->make(Kernel::class)->bootstrap();

       return $app;
    }
}
