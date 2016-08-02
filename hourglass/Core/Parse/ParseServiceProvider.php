<?php namespace Hourglass\Core\Parse;

use Illuminate\Support\ServiceProvider;
use Hourglass\Core\Parse\BBCode\BBCodeParser;
use Hourglass\Core\Parse\Sass\SassParser;

class ParseServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('parse.yaml', function() {
            return new Yaml;
        }, true);

        $this->app->bind('parse.bbcode', function() {
            return new BBCodeParser;
        }, true);

        $this->app->bind('parse.sass', function() {
            return new SassParser;
        }, true);
    }

    public function provides()
    {
        return [
            'parse.yaml',
            'parse.bbcode',
            'parse.sass',
        ];
    }
}