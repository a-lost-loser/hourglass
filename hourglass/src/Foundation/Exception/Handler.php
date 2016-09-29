<?php namespace Hourglass\Foundation\Exception;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as HandlerBase;

class Handler extends HandlerBase
{
    protected function convertExceptionToResponse(Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        return response()->make(
            $whoops->handleException($e),
            method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
            method_exists($e, 'getHeaders') ? $e->getHeaders() : []
        );
    }
}