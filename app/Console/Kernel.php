<?php

namespace App\Console;

use App\Console\Commands\UpdateBuffMarketCsgoItems;
use App\Console\Commands\UpdateSteamMarketCsgoDopplerItems;
use App\Console\Commands\UpdateSteamMarketCsgoItems;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(UpdateBuffMarketCsgoItems::class)
            ->cron('0 0 * * 1,3,5');

        $schedule->command(UpdateSteamMarketCsgoItems::class, ['--ignore-dopplers'])
            ->cron('0 12 * * *');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class)
            ->cron('0 0 * * *');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
