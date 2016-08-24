<?php

namespace Hourglass\Http\Middleware\Backend;

use Closure;
use Hourglass\Http\Middleware\HttpMiddleware;

class ShowErrorIfNotAuthorized implements HttpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}