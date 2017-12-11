<?php

namespace Tests\Unit\Plugin;

use Hourglass\Foundation\Plugins\PluginRepository;
use Tests\TestCase;

class PluginRepositoryTest extends TestCase
{
    public function setUp() {
        parent::setUp();

        $this->repository = $this->app->make(PluginRepository::class);
    }
    
    public function virtualPluginFolderContent()
    {
        return [
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
        ];
    }

    /** @test */
    public function it_automatically_discovers_plugins()
    {
        // Note that we do not call any methods on the repository for it to discover plugins.
        // This test checks, that discovery works when the application is run.

        $this->assertTrue($this->repository->wasDiscovered('acme/working'));
        $this->assertTrue($this->repository->wasDiscovered('acme/noentry'));
        $this->assertTrue($this->repository->wasDiscovered('acme/noplugin'));
    }

    /** @test */
    public function it_returns_information_about_errors_with_plugins()
    {
        $this->assertNull($this->repository->getError('nonexisting/plugin'));

        $this->assertEquals(PluginRepository::NO_ERROR, $this->repository->getError('acme/working'));
        $this->assertEquals(PluginRepository::ERROR_ENTRY_MISSING, $this->repository->getError('acme/noentry'));
        $this->assertEquals(PluginRepository::ERROR_ENTRY_NOT_A_PLUGIN, $this->repository->getError('acme/noplugin'));
    }

    /** @test */
    public function it_returns_the_path_to_plugins()
    {
        $this->assertNull($this->repository->getPath('nonexisting/plugin'));

        $this->assertEquals('vfs://plugins/acme/working', $this->repository->getPath('acme/working'));
    }
}
