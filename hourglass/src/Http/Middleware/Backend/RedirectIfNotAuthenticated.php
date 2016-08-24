<?php

namespace Hourglass\Http\Middleware\Backend;

use Closure;
use Hourglass\Http\Middleware\HttpMiddleware;

class RedirectIfNotAuthenticated implements HttpMiddleware
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
        if (auth()->guest() && $request->getPathInfo() != '/backend/login') {
            return redirect('/backend/login');
        }

        return $next($request);
    }
}