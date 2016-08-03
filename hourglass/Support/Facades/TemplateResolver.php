<?php namespace Hourglass\Support\Facades;

use Illuminate\Support\Facades\Facade;

class TemplateResolver extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'template.resolver';
    }
}