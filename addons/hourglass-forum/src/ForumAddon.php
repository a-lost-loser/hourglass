<?php namespace Hourglass\Forum;

use Hourglass\Plugin\Plugin as Base;
use TemplateResolver;
use Route;

class ForumAddon extends Base
{
    public $elevated = true;

    public $installer = Installer::class;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        TemplateResolver::addEvent($this, 'Hourglass.Backend::testing', 'main');
    }

    public function boot()
    {
        // throw new \Exception;
    }

    protected $routeNamespace = 'Controllers';

    public function routes()
    {
        Route::get('/', 'Forum\ListForumsController@listAction');
    }
}