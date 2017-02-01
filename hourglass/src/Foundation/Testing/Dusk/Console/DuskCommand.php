<?php

namespace Hourglass\Foundation\Testing\Dusk\Console;

use Laravel\Dusk\Console\DuskCommand as Command;
use Symfony\Component\Finder\Finder;

class DuskCommand extends Command
{
    /**
     * Purge the failure screenshots
     *
     * @return void
     */
    protected function purgeScreenshots()
    {
        $files = Finder::create()->files()
                        ->in(base_path('hourglass/tests/screenshots'))
                        ->name('failure-*');
        foreach ($files as $file) {
            @unlink($file->getRealPath());
        }
    }

    /**
     * Write the Dusk PHPUnit configuration.
     *
     * @return void
     */
    protected function writeConfiguration()
    {
        // We don't want to use the custom phpunit.xml file
        // copy(realpath(base_path('vendor/laravel/dusk/stubs/phpunit.xml')), base_path('phpunit.dusk.xml'));
    }

    /**
     * Remove the Dusk PHPUnit configuration.
     *
     * @return void
     */
    protected function removeConfiguration()
    {
        // We want to keep the phpunit.dusk.xml file
        // unlink(base_path('phpunit.dusk.xml'));
    }
}
