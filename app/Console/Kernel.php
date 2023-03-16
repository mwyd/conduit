<?php

namespace App\Console;

use App\Console\Commands\GenerateShadowpayWeeklySoldItemSparklines;
use App\Console\Commands\UpdateBuffMarketCsgoItems;
use App\Console\Commands\UpdateSteamMarketCsgoDopplerItems;
use App\Console\Commands\UpdateSteamMarketCsgoItems;
use App\Models\ShadowpayWeeklySoldItem;
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
            ->cron('0 4 * * *')
            ->runInBackground();

        $this->registerDopplerUpdates($schedule);

        $schedule->command(GenerateShadowpayWeeklySoldItemSparklines::class)
            ->cron('0 * * * *');

        $schedule->call(fn () => ShadowpayWeeklySoldItem::outdated()->delete())
            ->cron('0 10,22 * * *');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function registerDopplerUpdates(Schedule $schedule): void
    {
        $day = 1;

        for ($i = 0; $i < 10; $i += 2) {
            $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=' . $i])
                ->cron('0 12 * * ' . $day)
                ->runInBackground();

            $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=' . $i + 1])
                ->cron('0 20 * * ' . $day)
                ->runInBackground();

            $day++;
        }

        $schedule->command(UpdateSteamMarketCsgoDopplerItems::class, ['--chunk-id=10'])
            ->cron('0 20 * * ' . $day)
            ->runInBackground();
    }
}
