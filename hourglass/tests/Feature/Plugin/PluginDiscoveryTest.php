<?php

namespace Tests\Feature\Plugin;

use Hourglass\Foundation\Plugins\Discoverer;
use Hourglass\Foundation\Plugins\PluginRepository;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Tests\TestCase;

class ViewPluginDiscoveryTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    public function setUp()
    {
        $this->root = vfsStream::setup('plugins');
        $this->app = $this->createApplication();
    }

    /** @test */
    public function it_does_not_find_any_plugins_in_an_empty_plugins_folder()
    {
        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $this->assertEmpty($plugins);
    }

    /** @test */
    public function it_does_not_find_plugins_with_an_invalid_configuration_file()
    {
        vfsStream::create([
            'demo' => [
                'plugin1' => [ 'composer.json' => '' ],
                'plugin2' => [ 'composer.yaml' => '' ],
            ]
        ], $this->root);

        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $this->assertEmpty($plugins);
    }

    /** @test */
    public function it_can_find_plugins_with_a_valid_configuration()
    {
        vfsStream::create([
            'demo' => [
                'plugin1' => [ 'composer.json' => '' ],
                'plugin3' => [ 'composer.json' => '{"name":"demo/plugin2","version":"0.0.1"}' ],
            ]
        ], $this->root);

        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $this->assertEquals($plugins->count(), 1);
    }

    /** @test */
    public function it_can_find_plugins()
    {
        $repository = $this->app->make(PluginRepository::class);
        //dd($repository);
        // Test code
    }
}
