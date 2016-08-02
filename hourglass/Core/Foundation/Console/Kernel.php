<?php namespace Hourglass\Core\Foundation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

    ];

    protected function schedule(Schedule $schedule)
    {
        $this->bootstrap();
        $this->app['events']->fire('console.schedule', [$schedule]);
    }
}