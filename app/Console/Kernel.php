<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('import:prevair')->dailyAt('9:10');
        $schedule->command('import:gas')->hourly();
        $schedule->command('import:ter')->everyFiveMinutes();
        $schedule->command('import:football:season')->daily();
        $schedule->command('import:football:matchs')->everyFiveMinutes();
        $schedule->command('import:football:ranking')->hourly();
        $schedule->command('import:silex')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
