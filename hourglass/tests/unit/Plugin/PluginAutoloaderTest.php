<?php

namespace Tests\Unit\Plugin;

use Hourglass\Foundation\Plugins\Discoverer;
use Illuminate\Support\Collection;
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

        $discoverer = new Discoverer($this->virtualUrl('plugins'));
        $this->plugins = $discoverer->discover();

        $this->autoloader = require base_path('vendor/autoload.php');
    }

    public function virtualPluginFolderContent()
    {
        return [
            'acme' => [
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
        ];
    }

    /** @test */
    public function it_can_register_psr_4_autoloaders()
    {
        $psr = $this->plugins->filter(function ($p) {
            return $p->getIdentifier() == 'acme/psr4';
        })->first();

        $psr->registerAutoloaders($this->autoloader);

        $this->assertTrue(class_exists('\Acme\Psr4\AcmePsr4Test'));
    }

    /// TODO: Add Classmap and Mixed Tests.
}
