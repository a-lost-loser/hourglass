<?php namespace Hourglass\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class StringHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'string';
    }
}