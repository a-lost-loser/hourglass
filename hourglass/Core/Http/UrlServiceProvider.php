<?php namespace Hourglass\Core\Http;

use Log;
use Illuminate\Support\ServiceProvider;

class UrlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setUrlGeneratorPolicy();
    }

    public function setUrlGeneratorPolicy()
    {
        $policy = $this->app['config']->get('board.linkPolicy', 'detect');

        switch (strtolower($policy)) {
            case 'force':
                $appUrl = $this->app['config']->get('app.url');
                $this->app['url']->forceRootUrl($appUrl);
                break;
            case 'insecure':
                $this->app['url']->forceSchema('http');
                break;
            case 'secure':
                $this->app['url']->forceSchema('https');
                break;
        }
    }
}