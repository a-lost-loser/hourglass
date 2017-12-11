<?php

namespace Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\Debug\ExceptionHandler;
use Hourglass\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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

    protected function virtualUrl($url)
    {
        return vfsStream::url($url);
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(Exception $e) {}
            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }
}
