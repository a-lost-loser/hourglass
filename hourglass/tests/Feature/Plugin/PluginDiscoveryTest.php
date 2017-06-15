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

        // Set up virtual plugins
        vfsStream::create([
            'demo' => [
                'plugin1' => [ 'composer.json' => '' ],
                'plugin2' => [ 'composer.json' => '{"name":"demo/plugin2","version":"0.0.2"}' ],
                'plugin3' => [
                    'composer.json' => '{"name":"demo/plugin3","version":"0.0.1","extra":{"entry":"Demo\\\Test","priority":100}}'
                ],
            ]
        ], $this->root);
    }

    /** @test */
    public function it_can_find_plugins_with_a_valid_configuration()
    {
        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $this->assertEquals(2, $plugins->count());
    }

    /** @test */
    public function discovered_plugins_contain_identifiers_and_paths()
    {
        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $identifiers = $plugins->map(function ($i) {
            return $i->getIdentifier();
        })->toArray();

        $this->assertContains('demo/plugin2', $identifiers);
        $this->assertContains('demo/plugin3', $identifiers);
    }

    /** @test */
    public function discovered_plugins_contain_their_entry_class_and_a_priority()
    {
        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $plugins = $discoverer->discover();

        $map = $plugins->mapWithKeys(function ($plugin) {
            return [$plugin->getIdentifier() => [
                'priority' => $plugin->getBootPriority(),
                'entry'    => $plugin->getEntryClass(),
            ]];
        });

        // Boot priorities
        $this->assertEquals(10, $map['demo/plugin2']['priority']); // Default priority = 10
        $this->assertEquals(100, $map['demo/plugin3']['priority']);

        // Entry classes
        $this->assertNull($map['demo/plugin2']['entry']);
        $this->assertEquals('Demo\\Test', $map['demo/plugin3']['entry']);
    }
}
