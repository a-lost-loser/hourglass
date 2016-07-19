<?php namespace Hourglass\Forum;

use Hourglass\Core\Plugin\PluginInstaller;

class Installer extends PluginInstaller
{
    /**
     * @\Installation(version="1.0.0")
     */
    protected function installation_1()
    {
        $this->migrate();
    }
}