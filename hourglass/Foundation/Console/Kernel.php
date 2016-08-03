<?php namespace Hourglass\Foundation\Console;

use Hourglass\Addon\Console\MakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        MakeCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $this->bootstrap();
        $this->app['events']->fire('console.schedule', [$schedule]);
    }
}