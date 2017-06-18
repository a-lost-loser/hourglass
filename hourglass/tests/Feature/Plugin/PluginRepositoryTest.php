<?php

namespace Tests\Feature\Plugin;

use Hourglass\Foundation\Plugins\PluginRepository;
use org\bovigo\vfs\vfsStream;
use Tests\TestCase;

class PluginRepositoryTest extends TestCase
{
    public function setUpVirtualPlugins()
    {
        vfsStream::create([
            'acme' => [
                'working' => [
                    'composer.json' => '{"name":"acme/working","version":"0.0.1","autoload":{"psr-4":{"Acme\\\":"src"}},"extra":{"entry":"Acme\\\WorkingPlugin"}}',
                    'src' => [ 'WorkingPlugin.php' => '<?php namespace Acme; class WorkingPlugin extends \\Hourglass\\Foundation\\Plugins\\Plugin {}' ],
                ],
                'noentry' => [
                    'composer.json' => '{"name":"acme/noentry","version":"0.0.1"}',
                ],
                'noplugin' => [
                    'composer.json' => '{"name":"acme/noplugin","version":"0.0.1","autoload":{"psr-4":{"Acme\\\Noplugin\\\":"src"}},"extra":{"entry":"Acme\\\Noplugin\\\NotWorkingPlugin"}}',
                    'src' => [ 'NotWorkingPlugin.php' => '<?php namespace Acme\\Noplugin; class NotWorkingPlugin {}' ],
                ]
            ]
        ], $this->root);
    }

    /** @test */
    public function it_automatically_discovers_plugins()
    {
        $repository = $this->app->make(PluginRepository::class);

        $this->assertTrue($repository->wasDiscovered('acme/working'));
        $this->assertTrue($repository->wasDiscovered('acme/noentry'));
        $this->assertTrue($repository->wasDiscovered('acme/noplugin'));
    }

    /** @test */
    public function it_returns_information_about_errors_with_plugins()
    {
        $repository = $this->app->make(PluginRepository::class);

        $this->assertNull($repository->getError('nonexisting/plugin'));

        $this->assertEquals(PluginRepository::NO_ERROR, $repository->getError('acme/working'));
        $this->assertEquals(PluginRepository::ERROR_ENTRY_MISSING, $repository->getError('acme/noentry'));
        $this->assertEquals(PluginRepository::ERROR_ENTRY_NOT_A_PLUGIN, $repository->getError('acme/noplugin'));
    }

    /** @test */
    public function it_returns_the_path_to_plugins()
    {
        $repository = $this->app->make(PluginRepository::class);

        $this->assertNull($repository->getPath('nonexisting/plugin'));

        $this->assertEquals('vfs://plugins/acme/working', $repository->getPath('acme/working'));
    }
}
