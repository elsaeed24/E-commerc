<?php

namespace App\Console;

use App\Jobs\NewProductEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('optimize:clear')->dailyAt('04:00');

        // $job = new NewProductEmail();
        // $job->onConnection('database')->onQueue('emails');

        // $schedule->job($job)
        // ->onSuccess(function(){

        // })
        // ->onFailure(function(){

        // })
        // ->everyMinute();

        $schedule->job(new NewProductEmail())->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
