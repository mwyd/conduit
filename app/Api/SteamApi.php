<?php

namespace App\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class SteamApi
{
    private const URL = 'https://steamcommunity.com/market';

    public function getMarketListings(int $start, int $count): Response
    {
        return Http::get(self::URL.'/search/render/', [
            'query' => '',
            'start' => $start,
            'count' => $count,
            'search_descriptions' => 0,
            'sort_column' => 'popular',
            'sort_dir' => 'desc',
            'appid' => 730,
            'norender' => 1,
            'l' => 'english',
        ]);
    }

    public function getMarketItemListings(string $hashName, int $start, int $count): Response
    {
        return Http::get(self::URL."/listings/730/{$hashName}/render/", [
            'query' => '',
            'start' => $start,
            'count' => $count,
            'currency' => 1,
            'language' => 'english',
        ]);
    }
}
