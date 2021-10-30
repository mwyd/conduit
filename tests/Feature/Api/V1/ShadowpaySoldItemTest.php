<?php

namespace Tests\Feature\Api\V1;

use App\Models\ShadowpaySoldItem;
use App\Models\SteamMarketCsgoItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShadowpaySoldItemTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_index_request_returns_valid_data()
    {
        ShadowpaySoldItem::factory()
            ->count(10)
            ->create();

        ShadowpaySoldItem::factory()
            ->count(10)
            ->for(SteamMarketCsgoItem::factory())
            ->create();

        $response = $this->json('GET', '/api/v1/shadowpay-sold-items');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'hash_name',
                        'sold',
                        'avg_discount',
                        'avg_suggested_price',
                        'avg_steam_price',
                        'last_sold',
                        'steam_market_csgo_item'
                    ]
                ]
            ]);
    }

    public function test_single_request_returns_valid_data()
    {
        $item = ShadowpaySoldItem::factory()->create();

        $response = $this->json('GET', '/api/v1/shadowpay-sold-items/' . $item->hash_name);

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.hash_name', $item->hash_name);
    }

    public function test_single_request_returns_not_found()
    {
        $hashName = $this->faker()->words(3, true);

        $response = $this->json('GET', '/api/v1/shadowpay-sold-items/' . $hashName);

        $response
            ->assertStatus(404)
            ->assertJson([
                'success'       => false,
                'error_message' => 'not_found'
            ]);
    }

    public function test_single_trend_request_returns_valid_data()
    {
        $item = ShadowpaySoldItem::factory()->create();

        $response = $this->json('GET', '/api/v1/shadowpay-sold-items/' . $item->hash_name . '/trend');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'date',
                        'sold',
                        'avg_sell_price',
                        'avg_steam_price'
                    ]
                ]
            ]);
    }

    /**
     * @dataProvider createItemDataProvider
     */
    public function test_authorized_user_can_create_item($formData)
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['api:post']
        );

        $response = $this->json('POST', '/api/v1/shadowpay-sold-items', $formData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success'   => true,
                'data'      => $formData
            ]);
    }

    /**
     * @dataProvider createItemDataProvider
     */
    public function test_unauthorized_user_cannot_create_item($formData)
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('POST', '/api/v1/shadowpay-sold-items', $formData);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    /**
     * @dataProvider updateItemDataProvider
     */
    public function test_authorized_user_can_update_item($formData)
    {
        $item = ShadowpaySoldItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:put']
        );

        $response = $this->json('PUT', '/api/v1/shadowpay-sold-items/' . $item->transaction_id, $formData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => $formData + $item->toArray()
            ]);
    }

    /**
     * @dataProvider updateItemDataProvider
     */
    public function test_unauthorized_user_cannot_update_item($formData)
    {
        $item = ShadowpaySoldItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('PUT', '/api/v1/shadowpay-sold-items/' . $item->transaction_id, $formData);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    public function test_authorized_user_can_delete_item()
    {
        $item = ShadowpaySoldItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:delete']
        );

        $response = $this->json('DELETE', '/api/v1/shadowpay-sold-items/' . $item->transaction_id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => $item->toArray()
            ]);
    }

    public function test_unauthorized_user_cannot_delete_item()
    {
        $item = ShadowpaySoldItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('DELETE', '/api/v1/shadowpay-sold-items/' . $item->transaction_id);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    public function createItemDataProvider()
    {
        return [
            'valid data' => [
                [
                    'transaction_id'    => Str::random(),
                    'hash_name'         => 'AK-47 | Asiimov (Field-Tested)',
                    'suggested_price'   => 70.11,
                    'steam_price'       => 100.22,
                    'discount'          => 70,
                    'sold_at'           => date('Y-m-d H:i:s')
                ]
            ]
        ];
    }

    public function updateItemDataProvider()
    {
        return [
            'valid data' => [
                [
                    'suggested_price'   => 50.11,
                    'steam_price'       => 70.22,
                    'discount'          => 71
                ]
            ]
        ];
    }
}
