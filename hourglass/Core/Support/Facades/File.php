<?php namespace Hourglass\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class File extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'files';
    }
}