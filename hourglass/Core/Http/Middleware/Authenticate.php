<?php namespace Hourglass\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Hourglass\Core\Foundation\Contracts\MiddlewareContract;

class Authenticate implements MiddlewareContract
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (is_null($request->user())) {
            // Do nothing for now.
        }

        return $next($request);
    }

}