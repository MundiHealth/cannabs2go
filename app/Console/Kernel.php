<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use OnNow\Binot\Jobs\CompleteOrdersJob;
use OnNow\ExchangeRate\Job\DailyUpdateJob;
use Webkul\Sales\Jobs\InvoiceGenerateJob;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new DailyUpdateJob())->dailyAt('19:00')->timezone('America/Sao_Paulo');
        $schedule->job(new InvoiceGenerateJob())->everyTenMinutes();
        $schedule->job(new CompleteOrdersJob())->everyTenMinutes();
        $schedule->command('product:price:update')->dailyAt('21:00')->timezone('America/Sao_Paulo');
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
