<?php

namespace App\Console\Commands;

use App\Domain\Steam\SteamApi;
use App\Services\SteamMarketCsgoItemService;
use Illuminate\Console\Command;

class UpdateSteamMarketCsgoItems extends Command
{
    protected $signature = 'steam-market-csgo-item:update-all
        {--page-start=0}
        {--page-limit=220}
        {--per-page=100}
        {--request-delay=15}
        {--ignore-dopplers}';

    protected $description = 'Update all steam market csgo items';

    public function handle(SteamMarketCsgoItemService $steamMarketCsgoItemService, SteamApi $steamApi): void
    {
        $pageStart = (int) $this->option('page-start');
        $pageLimit = (int) $this->option('page-limit');
        $perPage = (int) $this->option('per-page');
        $requestDelay = (int) $this->option('request-delay');
        $ignoreDopplers = $this->option('ignore-dopplers');

        $bar = $this->output->createProgressBar($pageLimit * $perPage);

        $this->output->info('Fetching items');

        for ($i = $pageStart; $i < $pageLimit; $i++) {
            $response = $steamApi->getMarketListings($i * $perPage, $perPage);

            if (!$response->ok()) {
                break;
            }

            $listings = $response->json('results');

            if (!$listings) {
                break;
            }

            foreach ($listings as $listing) {
                if ($ignoreDopplers && str_contains($listing['hash_name'], 'Doppler (')) {
                    continue;
                }

                $steamMarketCsgoItemService->upsertFromSteamListing($listing);

                $bar->advance();
            }

            sleep($requestDelay);
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
