<?php

namespace Tests;

use Hourglass\Exceptions\Handler;

class RethrowingExceptionHandler extends Handler 
{
    public function __construct() {}

    public function report(Exception $e) {}

    public function render($request, Exception $e) 
    {
        throw $e;
    }
}