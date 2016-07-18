<?php namespace Communalizer\Forum;

use Communalizer\Core\Plugin\Plugin as Base;
use TemplateResolver;
use Route;

class Plugin extends Base
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

        TemplateResolver::addEvent($this, 'Communalizer.Backend::testing', 'main');
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