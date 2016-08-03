<?php namespace Hourglass\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Yaml extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "parse.yaml";
    }
}