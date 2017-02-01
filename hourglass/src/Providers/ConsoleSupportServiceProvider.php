<?php

namespace Hourglass\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        // 'Illuminate\Console\ScheduleServiceProvider',
        MigrationServiceProvider::class,
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        PulseServiceProvider::class,
    ];
}
