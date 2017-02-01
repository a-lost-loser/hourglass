<?php

namespace Hourglass\Foundation\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected function setUpTraits()
    {
        parent::setUpTraits();

        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[DatabaseSeeds::class])) {
            $this->runDatabaseSeeds();
        }
    }
}
