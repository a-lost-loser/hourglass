<?php namespace Hourglass\Core\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  protected $middleware = [
    \Illuminate\Session\Middleware\StartSession::class,
  ];

  protected $routeMiddleware = [
    'auth' => \Hourglass\Core\Http\Middleware\Authenticate::class,
  ]; 
}