<?php

namespace App\Console\Commands;

use App\Domain\Steam\SteamApi;
use App\Services\SteamMarketCsgoItemService;
use Illuminate\Console\Command;

class UpdateSteamMarketCsgoItems extends Command
{
    protected $signature = 'steam-market-csgo-item:update-all {--ignore-dopplers}';

    protected $description = 'Update all steam market csgo items';

    public function handle(SteamMarketCsgoItemService $steamMarketCsgoItemService, SteamApi $steamApi): void
    {
        $pageLimit = 220;
        $perPage = 100;

        $ignoreDopplers = $this->option('ignore-dopplers');

        $this->output->info('Fetching items');

        $bar = $this->output->createProgressBar($pageLimit * $perPage);

        for ($i = 0; $i < $pageLimit; $i++) {
            $response = $steamApi->getMarketListings($i * $perPage, $perPage);

            if ($response->status() == 429) {
                sleep(60);
                $i--;

                continue;
            }

            $success = $response->json('success');
            $totalCount = $response->json('searchdata.total_count');

            if (!$success || $totalCount == 0) {
                continue;
            }

            $listings = $response->json('results');

            foreach ($listings as $listing) {
                if ($ignoreDopplers && str_contains($listing['hash_name'], 'Doppler (')) {
                    continue;
                }

                $steamMarketCsgoItemService->upsertFromSteamListing($listing);

                $bar->advance();
            }

            if (count($listings) < $perPage) {
                break;
            }
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
