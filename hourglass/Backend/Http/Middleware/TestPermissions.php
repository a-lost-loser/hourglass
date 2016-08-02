<?php namespace Hourglass\Backend\Http\Middleware;

use Closure;
//use Hourglass\Backend\Models\User;
use Illuminate\Support\Facades\Auth;

class TestPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permissions = array_slice(func_get_args(), 2);

        $user = Auth::user();
        foreach ($permissions as $permission) {
            if ($user) {
                // $user->can($permission);
            } else {

            }
        }

        return $next($request);
    }
}