<?php namespace Hourglass\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as KernelBase;

class Kernel extends KernelBase
{
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'backend' => [
            'web',
            \Hourglass\Http\Middleware\Backend\RedirectIfNotAuthenticated::class,
            \Hourglass\Http\Middleware\Backend\ShowErrorIfNotAuthorized::class,
            \Hourglass\Http\Middleware\Backend\ShowErrorIfNotAuthorized::class,
        ],
    ];
}