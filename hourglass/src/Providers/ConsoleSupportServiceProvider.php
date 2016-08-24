<?php

namespace Hourglass\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        // 'Illuminate\Console\ScheduleServiceProvider',
        'Hourglass\Providers\MigrationServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Hourglass\Providers\PulseServiceProvider',
    ];
}