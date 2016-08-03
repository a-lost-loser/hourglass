<?php namespace Hourglass\Parse;

use Illuminate\Support\ServiceProvider;
use Hourglass\Parse\BBCode\BBCodeParser;
use Hourglass\Parse\Sass\SassParser;

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