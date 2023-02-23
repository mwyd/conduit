<?php

namespace App\Console\Commands;

use App\Domain\Steam\SteamApi;
use App\Services\SteamMarketCsgoItemService;
use Illuminate\Console\Command;

class UpdateSteamMarketCsgoDopplerItems extends Command
{
    protected $signature = 'steam-market-csgo-item:update-dopplers';

    protected $description = 'Update all steam market csgo doppler items';

    public function handle(SteamMarketCsgoItemService $steamMarketCsgoItemService, SteamApi $steamApi): void
    {
        $pageLimit = 50;
        $perPage = 10;

        $dopplerMap = $steamMarketCsgoItemService->getDopplerMap();

        $this->output->info('Fetching items');

        $bar = $this->output->createProgressBar(count($dopplerMap));

        foreach ($dopplerMap as $hashName => $icons) {
            $allListings = [];
            $allAssets = [];

            for ($i = 0; $i < $pageLimit; $i++) {
                $response = $steamApi->getMarketItemListings($hashName, $i * $perPage, $perPage);

                if ($response->status() == 429) {
                    sleep(60);
                    $i--;

                    continue;
                }

                $success = $response->json('success');
                $listings = $response->json('listinginfo');

                if (!$success || empty($listings)) {
                    continue;
                }

                $assets = $response->json('assets');

                $allListings += $listings;
                $allAssets += $assets['730']['2'];

                if (count($listings) < $perPage) {
                    break;
                }
            }

            $steamMarketCsgoItemService->upsertDopplerFromSteamListings($icons, $allListings, $allAssets);

            $bar->advance();
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }
}
