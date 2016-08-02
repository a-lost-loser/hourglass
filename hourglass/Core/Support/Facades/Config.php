<?php namespace Hourglass\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Config extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'config';
    }
}