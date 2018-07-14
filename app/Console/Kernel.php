<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\FillDetails;
use App\Console\Commands\ImportParts;
use App\Console\Commands\ImportTools;
use App\Console\Commands\ImportCavity;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        FillDetails::class,
        ImportParts::class,
        ImportTools::class,
        ImportCavity::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //make schedule to import part details & tools details so that user can get the data easier.
        

        $schedule->command('detail:fill')
        // ->everyFiveMinutes()
        // ->everyMinute()
        // ->runInBackground()
        ->daily('09:45')
        ->appendOutputTo(storage_path('logs\fillDetails.log'));

        // $schedule->exec('echo hellow world')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
