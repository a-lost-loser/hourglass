<?php namespace Hourglass\Plugin;

use Doctrine\Common\Annotations\AnnotationReader;

class PluginInstaller
{
    protected $plugin;

    public function install(Plugin $plugin)
    {
        $this->plugin = $plugin;
        $version = $plugin->configuration->get('plugin.version');

        // anything < dev < alpha (a) < beta (b) < RC (rc) < # < pl (p)
        dd($this->getAvailableInstallations());
    }

    private function getAvailableInstallations()
    {
        $reader = new AnnotationReader;

        $methods = get_class_methods($this);
        $annotations = [];
        foreach ($methods as $method) {
            $reflectionMethod = new \ReflectionMethod($this, $method);
            $annotation = $reader->getMethodAnnotation($reflectionMethod, 'Installation');

            if ($annotation) {
                $annotations[$method] = str_replace(' ', '', $annotation->version);
            }
        }

        uasort($annotations, 'version_compare');

        return $annotations;
    }

    protected final function migrate()
    {

    }
}