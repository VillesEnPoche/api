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
    protected $commands
        = [
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
        $schedule->command('import:prevair')->dailyAt('9:10')
            ->then(function () {
                $this->call('images:pollutant');
                $this->call('socials:pollutant');
            });
        $schedule->command('import:theater')->dailyAt('7:00');
        $schedule->command('import:gas')->runInBackground()->hourly();
        $schedule->command('import:ter')->runInBackground()->everyFiveMinutes();
        $schedule->command('import:football:season')->runInBackground()->daily();
        $schedule->command('import:football:matchs')->runInBackground()->everyFiveMinutes();
        $schedule->command('import:football:ranking')->runInBackground()->hourly();
        $schedule->command('import:silex')->runInBackground()->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
