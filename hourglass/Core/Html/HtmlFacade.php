<?php namespace Hourglass\Core\Html;

use Illuminate\Support\Facades\Facade;

class HtmlFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'html';
    }
}