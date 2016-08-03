<?php namespace Hourglass\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \Illuminate\Session\Middleware\StartSession::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
        ]
    ];

    protected $routeMiddleware = [
        'auth' => \Hourglass\Http\Middleware\Authenticate::class,
    ];
}