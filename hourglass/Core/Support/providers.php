<?php

return [

    Hourglass\Core\Foundation\Providers\AppServiceProvider::class,
    Hourglass\Core\Html\HtmlServiceProvider::class,
    Hourglass\Core\Parse\ParseServiceProvider::class,
    Hourglass\Core\Http\UrlServiceProvider::class,
    Hourglass\Core\File\FilesystemServiceProvider::class,
    Hourglass\Core\Config\ConfigServiceProvider::class,

    Hourglass\Core\Database\MigrationServiceProvider::class,
    // App\Providers\AuthServiceProvider::class,
    // App\Providers\EventServiceProvider::class,
    // App\Providers\RouteServiceProvider::class,

];