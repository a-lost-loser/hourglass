<?php namespace Hourglass\Core\Foundation\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        // \Illuminate\Auth\GeneratorServiceProvider::class,
        \Illuminate\Console\ScheduleServiceProvider::class,
        \Illuminate\Database\SeedServiceProvider::class,
        \Illuminate\Foundation\Providers\ComposerServiceProvider::class,
        \Illuminate\Queue\ConsoleServiceProvider::class,
        // \Illuminate\Routing\GeneratorServiceProvider::class,
        // \Illuminate\Session\CommandsServiceProvider::class,

        \Hourglass\Core\Database\MigrationServiceProvider::class,
    ];
}
