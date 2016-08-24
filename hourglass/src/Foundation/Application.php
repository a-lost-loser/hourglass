<?php namespace Hourglass\Foundation;

use Illuminate\Foundation\Application as ApplicationBase;

class Application extends ApplicationBase
{
    public function databasePath()
    {
        return $this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'hourglass'.DIRECTORY_SEPARATOR.'database';
    }
}