<?php

namespace App\Console;

use App\Jobs\DailyMetricsTask;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Cronitor\Cronitor;


class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */

    protected function schedule(Schedule $schedule): void
    {
        // Example: Run your custom notification command every 5 minutes
        // $schedule->command('app:send-job-alerts')->dailyAt('08:00');
        $schedule->command('alerts:send')->daily();
        // $schedule->command('alerts:send')->dailyAt('08:00');
        $schedule->command('jobs:expired-featured')->daily();
        $schedule->command('app:expire-subscriptions')->daily();
        $schedule->command('notifications:backfill-job-titles')->dailyAt('02:00');
    }

    protected $commands = [
        \App\Console\Commands\BackfillNotificationJobTitles::class,
    ];
}
