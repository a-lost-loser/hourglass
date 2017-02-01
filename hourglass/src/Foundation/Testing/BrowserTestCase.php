<?php

namespace Hourglass\Foundation\Testing;

use Laravel\Dusk\TestCase as BaseTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class BrowserTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Register the base URL with Dusk.
     *
     * @before
     * @return void
     */
    public function propagateScaffoldingToBrowser()
    {
        Browser::$baseUrl = $this->baseUrl();

        Browser::$storeScreenshotsAt = base_path('tests/screenshots');

        Browser::$userResolver = function () {
            return $this->user();
        };
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }
    
    protected function setUpTraits()
    {
        parent::setUpTraits();

        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[DatabaseSeeds::class])) {
            $this->runDatabaseSeeds();
        }
    }
}
