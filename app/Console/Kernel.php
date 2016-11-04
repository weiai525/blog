<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
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
        //5分钟删除过期文件
        $schedule->call(function () {
            $files = Storage::disk('public')->files();
            foreach ($files as $key => $value) {
                if (Storage::disk('public')->lastModified($value) + 300 < time()) {
                    Storage::disk('public')->delete($value);
                }
            }
        })->everyFiveMinutes();

    }
}
