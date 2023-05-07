<?php

namespace App\Console\Commands;

use App\Repositories\ShadowpayWeeklySoldItemRepository;
use App\Utility\Sparkline\Sparkline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateShadowpayWeeklySoldItemSparklines extends Command
{
    protected $signature = 'shadowpay-weekly-sold-item:generate-sparklines';

    protected $description = 'Generate sparklines for all weekly sold shadowpay items';

    public function handle(ShadowpayWeeklySoldItemRepository $shadowpayWeeklySoldItemRepository): void
    {
        $history = $shadowpayWeeklySoldItemRepository->getItemsPriceHistory();

        $bar = $this->output->createProgressBar($history->count());

        $this->output->info('Generating sparklines');

        foreach ($history as $hashName => $rows) {
            $prices = $rows->pluck('price');

            $first = $prices->first();
            $last = $prices->last();

            $color = $first < $last ? '#57bd0f' : '#ed5565';

            $sparkline = Sparkline::make($prices)
                ->withColor($color)
                ->render();

            Storage::put(
                'public/sparkline/7d/'.md5($hashName).'.svg',
                $sparkline
            );

            $bar->advance();
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
