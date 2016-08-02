<?php namespace Hourglass\Backend\Http\Middleware;

use Closure;
//use Hourglass\Backend\Models\User;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
        //$user = User::find(1);
        //Auth::login($user);

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect()->guest('backend/login');
        }

        return $next($request);
    }
}