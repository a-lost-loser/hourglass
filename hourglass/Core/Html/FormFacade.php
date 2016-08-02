<?php namespace Hourglass\Core\Html;

use Illuminate\Support\Facades\Facade;

class FormFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'form';
    }
}