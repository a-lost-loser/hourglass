<?php

use Hourglass\Addon\Addon;
use Hourglass\Addon\AddonRepository;
use Hourglass\Foundation\Testing\TestCase;

class AddonInitializationTest extends TestCase
{
    public function test_it_can_load_arbitrary_addons()
    {
        $stub = Mockery::spy(Addon::class);

        $repository = $this->app->make(AddonRepository::class);
        $repository->enableAddon($stub);

        $stub->shouldHaveReceived('enable')->once();
    }
}