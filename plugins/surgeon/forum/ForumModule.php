<?php namespace Surgeon\Forum;

use Surgeon\Nurse\Plugin\PluginBase;

class ForumModule extends PluginBase
{
    /**
     * Forum Module is an elevated plugin as it extends core functionality and needs to be booted.
     * 
     * @var bool
     */
    public $elevated = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        dd($this->getConfigurationFromYaml());
    }
}