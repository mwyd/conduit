<?php

namespace App\Services;

use App\Models\SteamMarketCsgoItem;
use App\Utility\DopplerKnife;
use App\Utility\DopplerWeapon;

class SteamMarketCsgoItemService
{
    private string $stattrakKeyword = 'StatTrak™ ';

    private array $exteriors = [
        'FN' => ' (Factory New)',
        'MW' => ' (Minimal Wear)',
        'FT' => ' (Field-Tested)',
        'WW' => ' (Well-Worn)',
        'BS' => ' (Battle-Scarred)',
        'Foil' => ' (Foil)',
        'Holo' => ' (Holo)',
        'Gold' => ' (Gold)',
        'Blue' => ' (Blue)',
        'Red' => ' (Red)',
    ];

    private array $typeColors = [
        'Contraband' => '#FFAE39',
        'Covert' => '#EB4B4B',
        'Extraordinary' => '#EB4B4B',
        'Master' => '#EB4B4B',
        'Classified' => '#D32EE6',
        'Exotic' => '#D32EE6',
        'Superior' => '#D32EE6',
        'Restricted' => '#8847FF',
        'Remarkable' => '#8847FF',
        'Exceptional' => '#8847FF',
        'Mil-Spec' => '#4B69FF',
        'High Grade' => '#4B69FF',
        'Distinguished' => '#4B69FF',
        'Industrial Grade' => '#5E98D9',
        'Consumer Grade' => '#B0C3D9',
        'Base Grade' => '#B0C3D9',
    ];

    public function getDopplerMap(): array
    {
        $map = [];

        foreach (DopplerKnife::$icons as $name => $icons) {
            foreach (DopplerKnife::$exteriors as $exterior) {
                $hashName = "{$name} {$exterior}";
                $stattrakHashName = str_replace('★', '★ StatTrak™', $hashName);

                $map[$hashName] = $icons;
                $map[$stattrakHashName] = $icons;
            }
        }

        foreach (DopplerWeapon::$icons as $name => $icons) {
            $map[$name] = $icons;
        }

        return $map;
    }

    public function upsertDopplerFromSteamListings(array $icons, array $listings, array $assets): void
    {
        $items = [];

        foreach ($listings as $listing) {
            $id = $listing['asset']['id'];

            $items[$id] = [
                'sell_listings' => 1,
                'sell_price' => ($listing['converted_price'] ?? 0) + ($listing['converted_fee'] ?? 0),
            ];
        }

        uasort($items, fn ($a, $b) => $a['sell_price'] - $b['sell_price']);

        $grouped = [];

        foreach ($assets as $asset) {
            $id = $asset['id'];
            $icon = $asset['icon_url'];
            $iconLarge = $asset['icon_url_large'];

            $phase = $icons[$icon] ?? $icons[$iconLarge] ?? null;

            if (! $phase) {
                continue;
            }

            if (array_key_exists($phase, $grouped)) {
                $grouped[$phase]['sell_listings']++;

                continue;
            }

            $grouped[$phase] = $items[$id] + [
                'hash_name' => $this->formatDopplerHashName($asset['market_hash_name'], $phase),
                'asset_description' => [
                    'icon_url' => $icon,
                    'icon_url_large' => $iconLarge,
                    'name_color' => $asset['name_color'],
                    'type' => $asset['type'],
                    'phase' => $phase,
                    'descriptions' => $asset['descriptions'],
                ],
            ];
        }

        foreach ($grouped as $item) {
            $this->upsertFromSteamListing($item);
        }
    }

    public function upsertFromSteamListing(array $listing): void
    {
        $item = SteamMarketCsgoItem::find($listing['hash_name']);

        if ($item) {
            $item->volume = $listing['sell_listings'];
            $item->price = $listing['sell_price'] / 100;

            $item->save();

            return;
        }

        $assetDescription = $listing['asset_description'];

        $this->createFromRequestData([
            'hash_name' => $listing['hash_name'],
            'volume' => $listing['sell_listings'],
            'price' => $listing['sell_price'] / 100,
            'icon' => $assetDescription['icon_url'],
            'icon_large' => ($assetDescription['icon_url_large'] ?? '') ?: null,
            'name_color' => '#'.$assetDescription['name_color'],
            'type' => $assetDescription['type'],
            'phase' => $assetDescription['phase'] ?? null,
            'collection' => $this->getCollectionFromDescriptions($assetDescription['descriptions'] ?? []),
        ]);
    }

    public function createFromRequestData(array $requestData): SteamMarketCsgoItem
    {
        return SteamMarketCsgoItem::create($this->prepareData($requestData));
    }

    private function prepareData(array $requestData): array
    {
        $data = [
            'is_stattrak' => false,
            'exterior' => null,
            'name' => $requestData['hash_name'],
            'type_color' => $requestData['name_color'],
            ...$requestData,
        ];

        if (str_contains($data['name'], $this->stattrakKeyword)) {
            $data['name'] = str_replace($this->stattrakKeyword, '', $data['name']);
            $data['is_stattrak'] = true;
        }

        foreach ($this->exteriors as $short => $exterior) {
            if (str_contains($data['name'], $exterior)) {
                $data['name'] = str_replace($exterior, '', $data['name']);
                $data['exterior'] = $short;

                break;
            }
        }

        foreach ($this->typeColors as $type => $color) {
            if (str_contains($data['type'], $type)) {
                $data['type_color'] = $color;

                break;
            }
        }

        return $data;
    }

    private function getCollectionFromDescriptions(array $descriptions): ?string
    {
        foreach ($descriptions as $description) {
            if (isset($description['color']) && $description['color'] == '9da1a9') {
                return $description['value'];
            }
        }

        return null;
    }

    private function formatDopplerHashName(string $hashName, string $phase): string
    {
        return str_replace('(', "{$phase} (", $hashName);
    }
}
