<?php namespace Hourglass\Addon\Facades;

use Illuminate\Support\Facades\Facade;

class Addons extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'addons.repository';
    }
}