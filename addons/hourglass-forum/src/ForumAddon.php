<?php namespace Hourglass\Forum;

use Hourglass\Addon\Addon;
use TemplateResolver;
use Route;

class ForumAddon extends Addon
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

    }

    protected $routeNamespace = 'Controllers';

    public function routes()
    {
        Route::get('/', 'Forum\ListForumsController@listAction');
    }
}