<?php namespace Koolbeans\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Koolbeans\Console\Commands\ChargeAwaitingRecentTransactionsCommand;
use Koolbeans\Console\Commands\CreateXeroBillsCommand;
use Koolbeans\Console\Commands\SendEmailsCommand;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ChargeAwaitingRecentTransactionsCommand::class,
        CreateXeroBillsCommand::class,
        SendEmailsCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('transactions:charge')->daily();
        $schedule->command('transactions:xero')->daily();
        $schedule->command('emails:send')->weekly(7);
    }

}
