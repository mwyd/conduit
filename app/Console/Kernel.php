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
            ->cron('0 0 * * 1,3,5')
            ->runInBackground();

        $schedule->command(UpdateSteamMarketCsgoItems::class, ['--ignore-dopplers'])
            ->cron('0 4 * * *');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=0'])
            ->cron('0 12 * * 1');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=1'])
            ->cron('0 20 * * 1');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=2'])
            ->cron('0 12 * * 2');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=3'])
            ->cron('0 20 * * 2');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=4'])
            ->cron('0 12 * * 3');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=5'])
            ->cron('0 20 * * 3');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=6'])
            ->cron('0 12 * * 4');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=7'])
            ->cron('0 20 * * 4');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=8'])
            ->cron('0 12 * * 5');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=9'])
            ->cron('0 20 * * 5');

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=10'])
            ->cron('0 12 * * 6');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
