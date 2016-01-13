<?php namespace Surgeon\Forum;

use Surgeon\Nurse\Plugin\ModuleBase;

class ForumModule extends ModuleBase
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__.'/files/routes.php';
    }

    public function boot()
    {

    }
}