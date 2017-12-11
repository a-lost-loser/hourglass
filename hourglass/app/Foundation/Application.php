<?php

namespace Hourglass\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    protected $databasePath = __DIR__ . '/../../database';
}