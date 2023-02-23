<?php

namespace App\Console\Commands;

use App\Domain\Buff\BuffApi;
use App\Models\BuffMarketCsgoItem;
use App\Services\ExchangeRateService;
use Illuminate\Console\Command;

class UpdateBuffMarketCsgoItems extends Command
{
    protected $signature = 'buff-market-csgo-item:update-all';

    protected $description = 'Update all buff market csgo items';

    public function handle(ExchangeRateService $exchangeService, BuffApi $buffApi): void
    {
        $exchangeRate = $exchangeService->getExchangeRate('CNY', 'USD') ?? 0.15;

        $items = BuffMarketCsgoItem::all();

        $this->output->info('Fetching items');

        $bar = $this->output->createProgressBar(count($items));

        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];

            $response = $buffApi->getSellOrders($item->good_id);

            if ($response->status() == 429) {
                sleep(20);
                $i--;

                continue;
            }

            $code = $response->json('code');
            $orders = $response->json('data');

            if ($code != 'OK' || empty($orders['items'])) {
                continue;
            }

            $item->update([
                'volume' => $orders['total_count'],
                'price' => round($orders['items'][0]['price'] * $exchangeRate, 2)
            ]);

            $bar->advance();
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
