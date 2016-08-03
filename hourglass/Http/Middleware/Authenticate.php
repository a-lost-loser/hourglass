<?php namespace Hourglass\Http\Middleware;

use Closure;
use Auth;
use Hourglass\Foundation\Contracts\MiddlewareContract;

class Authenticate implements MiddlewareContract
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect()->guest('backend/login');
        }

        return $next($request);
    }
}
