<?php

namespace App\Console\Commands;

use App\Api\BuffApi;
use App\Models\BuffMarketCsgoItem;
use App\Services\ExchangeRateService;
use Illuminate\Console\Command;

class UpdateBuffMarketCsgoItems extends Command
{
    protected $signature = 'buff-market-csgo-item:update-all
        {--default-exchange=0.15}
        {--request-delay=1}';

    protected $description = 'Update all buff market csgo items';

    public function handle(ExchangeRateService $exchangeService, BuffApi $buffApi): void
    {
        $defaultExchange = (float) $this->option('default-exchange');
        $requestDelay = (int) $this->option('request-delay');

        $exchangeRate = $exchangeService->getExchangeRate('CNY', 'USD') ?? $defaultExchange;

        $items = BuffMarketCsgoItem::all();

        $bar = $this->output->createProgressBar(count($items));

        $this->output->info('Fetching items');

        foreach ($items as $item) {
            $response = $buffApi->getSellOrders($item->good_id);

            if (!$response->ok()) {
                continue;
            }

            $code = $response->json('code');
            $orders = $response->json('data');

            if ($code == 'OK' && count($orders['items']) > 0) {
                $item->volume = $orders['total_count'];
                $item->price = round($orders['items'][0]['price'] * $exchangeRate, 2);

                $item->save();
            }

            $bar->advance();

            sleep($requestDelay);
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
