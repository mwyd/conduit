<?php

namespace Tests\Integration\Api;

use App\Domain\Steam\SteamApi;
use Tests\TestCase;

class SteamApiTest extends TestCase
{
    private ?SteamApi $steamApi;

    public function test_steam_api_get_market_listings_return_ok_response(): void
    {
        $response = $this->steamApi->getMarketListings(0, 1);

        $this->assertEquals(200, $response->status());

        ['success' => $success, 'results' => $results] = $response->json();

        $this->assertTrue($success);

        $item = array_shift($results);

        $this->assertIsString($item['hash_name']);
        $this->assertIsInt($item['sell_listings']);
        $this->assertIsInt($item['sell_price']);

        $assetDescription = $item['asset_description'];

        $this->assertIsString($assetDescription['icon_url']);

        $this->assertIsString($assetDescription['name_color']);
        $this->assertIsString($assetDescription['type']);

        $iconLarge = $assetDescription['icon_url_large'] ?? null;

        $this->assertTrue(is_null($iconLarge) || is_string($iconLarge));

        $descriptions = $assetDescription['descriptions'] ?? null;

        $this->assertTrue(is_null($descriptions) || is_array($descriptions));
    }

    public function test_steam_api_get_market_item_listings_return_ok_response(): void
    {
        $response = $this->steamApi->getMarketItemListings('AK-47 | Redline (Field-Tested)', 0, 1);

        $this->assertEquals(200, $response->status());

        ['success' => $success, 'listinginfo' => $listings, 'assets' => $assets] = $response->json();

        $this->assertTrue($success);

        $listing = array_shift($listings);

        $this->assertIsString($listing['asset']['id']);
        $this->assertIsInt($listing['converted_price']);
        $this->assertIsInt($listing['converted_fee']);

        $asset = array_shift($assets['730']['2']);

        $this->assertIsString($asset['id']);
        $this->assertIsString($asset['icon_url']);
        $this->assertIsString($asset['icon_url_large']);
        $this->assertIsString($asset['market_hash_name']);
        $this->assertIsString($asset['name_color']);
        $this->assertIsString($asset['type']);

        $descriptions = $asset['descriptions'] ?? null;

        $this->assertTrue(is_null($descriptions) || is_array($descriptions));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->steamApi = new SteamApi();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->steamApi = null;
    }
}
