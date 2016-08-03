<?php namespace Hourglass\Html;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->registerHtmlBuilder();

        $this->registerFormBuilder();
    }

    protected function registerHtmlBuilder()
    {
        $this->app->bind('html', function($app) {
            return new HtmlBuilder($app['url'], $app['view']);
        }, true);
    }

    protected function registerFormBuilder()
    {
        $this->app->bind('form', function($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken(), str_random(40));
            return $form->setSessionStore($app['session.store']);
        }, true);
    }

    public function provides()
    {
        return ['html', 'form'];
    }
}