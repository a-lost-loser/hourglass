<?php

namespace Hourglass\Http\Middleware\Backend;

use Closure;
use Hourglass\Http\Middleware\HttpMiddleware;
use Illuminate\Validation\UnauthorizedException;

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
        if (!$request->user() || !$request->user()->can('Hourglass.Backend::access.backend')) {
            throw new UnauthorizedException('You are not authorized to access the backend.');
        }

        return $next($request);
    }
}