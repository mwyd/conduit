<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCurrencies extends Command
{
    private const CURRENCIES = ['USD', 'EUR', 'CNY', 'PLN'];

    protected $signature = 'currency:update-all {base=USD}';

    protected $description = 'Update currencies and save them into cache';

    public function handle(ExchangeRateService $exchangeRateService): void
    {
        $base = $this->argument('base');

        $this->output->info('Updating currencies');

        $bar = $this->output->createProgressBar(count(self::CURRENCIES));

        $updated = [];

        foreach (self::CURRENCIES as $currency) {
            $ratio = $exchangeRateService->getExchangeRate($base, $currency);

            if ($ratio === null) {
                continue;
            }

            $updated[$currency] = $ratio;

            $bar->advance();
        }

        $bar->finish();

        Cache::set('currencies', $updated);

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
