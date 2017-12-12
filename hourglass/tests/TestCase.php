<?php

namespace Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        // Set up VFS Stream along the way, so every time the application is
        // being booted, the virtual plugin path is available as well.
        $root = vfsStream::setup('plugins');

        if (method_exists($this, 'virtualPluginFolderContent')) {
            vfsStream::create($this->virtualPluginFolderContent(), $root);
        }

        parent::setUp();
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function virtualUrl($url)
    {
        return vfsStream::url($url);
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new RethrowingExceptionHandler);
    }
}
