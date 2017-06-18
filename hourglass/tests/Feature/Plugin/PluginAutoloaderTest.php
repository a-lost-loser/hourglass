<?php

namespace Tests\Feature\Plugin;

use Hourglass\Foundation\Plugins\Discoverer;
use Illuminate\Support\Collection;
use org\bovigo\vfs\vfsStream;
use Tests\TestCase;

class PluginAutoloaderTest extends TestCase
{
    /**
     * @var Collection
     */
    private $plugins;

    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $autoloader;

    public function setUp()
    {
        parent::setUp();

        $discoverer = new Discoverer(vfsStream::url('plugins'));
        $this->plugins = $discoverer->discover();

        $this->autoloader = require base_path('vendor/autoload.php');
    }

    public function setUpVirtualPlugins()
    {
        vfsStream::create([
            'acme' => [
                'psr0' => [
                    'composer.json' => '{"name":"acme/psr0","version":"0.0.1","autoload":{"psr-0":{"Acme\\\":"src"}}}',
                    'src' => [ 'AcmePsr0Test.php' => '<?php namespace Acme; class AcmePsr0Test {}' ],
                ],
                'psr4' => [
                    'composer.json' => '{"name":"acme/psr4","version":"0.0.1","autoload":{"psr-4":{"Acme\\\Psr4\\\":"src"}}}',
                    'src' => [ 'AcmePsr4Test.php' => '<?php namespace Acme\\Psr4; class AcmePsr4Test {};' ],
                ],
                'classmap' => [
                    'composer.json' => '{"name":"acme/classmap","version":"0.0.1","autoload":{"classmap":["src/"]}}',
                    'src' => [ 'AcmeClassmapTest.php' => '<?php class AcmeClassmapTest {};' ],
                ],
                'mixed' => [
                    'composer.json' => '{"name":"acme/mixed","version":"0.0.1","autoload":{"classmap":["map"],"psr-4":{"Acme\\\Mixed\\\":"src"}}}',
                    'map' => [ 'AcmeMixedClassmapTest.php' => '<?php class AcmeMixedClassmapTest {}' ],
                    'src' => [ 'AcmeMixedPsr4Test.php' => '<?php namespace Acme\\Mixed; class AcmeMixedPsr4Test {}' ],
                ],
            ]
        ], $this->root);
    }

    /** @test */
    public function it_can_register_psr_4_autoloaders()
    {
        $psr0 = $this->plugins->filter(function ($p) {
            return $p->getIdentifier() == 'acme/psr4';
        })->first();

        $psr0->registerAutoloaders($this->autoloader);

        $this->assertTrue(class_exists('\Acme\Psr4\AcmePsr4Test'));
    }

    /// TODO: Add PSR-0 and Classmap Tests.
}
