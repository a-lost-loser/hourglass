<?php namespace Hourglass\Core\Foundation\Contracts;

use Closure;
use Illuminate\Http\Request;

interface MiddlewareContract
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request
     * @param Closure     $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null);
}