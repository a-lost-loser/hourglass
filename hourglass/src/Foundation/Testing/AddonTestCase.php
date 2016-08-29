<?php

namespace Hourglass\Foundation\Testing;

use Hourglass\Addon\AddonRepository;

abstract class AddonTestCase extends TestCase
{
    public function createApplication()
    {
        // Addons don't use Hourglass's autoload.php for testing.
        // Therefore the helper functions are not loaded by default.
        require_once __DIR__.'/../../../../hourglass/helpers.php';

        return parent::createApplication();
    }

    public function setUp()
    {
        parent::setUp();

        if (env('ADDON_CLASS_NAME')) {
            $repository = $this->app->make(AddonRepository::class);
            $repository->enableAddon(env('ADDON_CLASS_NAME'));
        }
    }
}
