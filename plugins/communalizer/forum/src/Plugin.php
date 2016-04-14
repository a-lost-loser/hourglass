<?php namespace Communalizer\Forum;

use Communalizer\Core\Plugin\PluginBase;
use TemplateResolver;
use View;

class Plugin extends PluginBase
{
    public $elevated = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        View::addNamespace('Communalizer.Forum', __DIR__.'/../files/resources/views');
        TemplateResolver::addEvent($this, 'Communalizer.Backend::testing', 'main');
    }

    public function boot()
    {
        // throw new \Exception;
    }
}