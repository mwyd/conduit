<?php

namespace App\Console\Commands;

use App\Domain\Steam\SteamApi;
use App\Services\SteamMarketCsgoItemService;
use Illuminate\Console\Command;

class UpdateSteamMarketCsgoDopplerItems extends Command
{
    protected $signature = 'steam-market-csgo-item:update-dopplers
        {--page-limit=2}
        {--per-page=100}
        {--request-delay=180}';

    protected $description = 'Update all steam market csgo doppler items';

    public function handle(SteamMarketCsgoItemService $steamMarketCsgoItemService, SteamApi $steamApi): void
    {
        $pageLimit = (int) $this->option('page-limit');
        $perPage = (int) $this->option('per-page');
        $requestDelay = (int) $this->option('request-delay');

        $dopplerMap = $steamMarketCsgoItemService->getDopplerMap();

        $bar = $this->output->createProgressBar(count($dopplerMap));

        $this->output->info('Fetching items');

        foreach ($dopplerMap as $hashName => $icons) {
            $allListings = [];
            $allAssets = [];

            for ($i = 0; $i < $pageLimit; $i++) {
                $response = $steamApi->getMarketItemListings($hashName, $i * $perPage, $perPage);

                if (!$response->ok()) {
                    break;
                }

                $listings = $response->json('listinginfo', []);
                $assets = $response->json('assets.730.2', []);

                if (count($listings) > 0 && count($listings) == count($assets)) {
                    $allListings += $listings;
                    $allAssets += $assets;
                }

                if (count($listings) < $perPage) {
                    break;
                }

                sleep($requestDelay);
            }

            $steamMarketCsgoItemService->upsertDopplerFromSteamListings($icons, $allListings, $allAssets);

            $bar->advance();

            sleep($requestDelay);
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
