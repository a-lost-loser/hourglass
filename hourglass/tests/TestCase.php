<?php

namespace Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    public function setUp()
    {
        // Set up VFS Stream along the way, so every time the application is
        // being booted, the virtual plugin path is available as well.
        $this->root = vfsStream::setup('plugins');

        if (method_exists($this, 'setUpVirtualPlugins')) {
            $this->setUpVirtualPlugins();
        }

        parent::setUp();
    }
}
