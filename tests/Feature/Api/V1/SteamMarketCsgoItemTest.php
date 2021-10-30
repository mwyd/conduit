<?php

namespace Tests\Feature\Api\V1;

use App\Models\SteamMarketCsgoItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SteamMarketCsgoItemTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_index_request_returns_valid_data()
    {
        $items = SteamMarketCsgoItem::factory()
            ->count(20)
            ->create()
            ->toArray();

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => usort($items, function ($a, $b) { return $a['volume'] - $b['volume']; })
            ]);
    }

    public function test_single_request_returns_valid_data()
    {
        $item = SteamMarketCsgoItem::factory()->create();

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items/' . $item->hash_name);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => $item->toArray()
            ]);
    }

    public function test_single_request_returns_not_found()
    {
        $hashName = $this->faker()->words(3, true);

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items/' . $hashName);

        $response
            ->assertStatus(404)
            ->assertJson([
                'success'       => false,
                'error_message' => 'not_found'
            ]);
    }

    /**
     * @dataProvider postItemDataProvider
     */
    public function test_authorized_user_can_create_item($formData)
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['api:post']
        );

        $response = $this->json('POST', '/api/v1/steam-market-csgo-items', $formData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success'   => true,
                'data'      => $formData
            ]);
    }

    /**
     * @dataProvider postItemDataProvider
     */
    public function test_unauthorized_user_cannot_create_item($formData)
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('POST', '/api/v1/steam-market-csgo-items', $formData);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    public function test_authorized_user_can_update_item()
    {
        $item = SteamMarketCsgoItem::factory()->create();

        $formData = [
            'volume'    => $this->faker()->numberBetween(0, 100),
            'price'     => $this->faker()->randomFloat(2, 0 ,100)
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:put']
        );

        $response = $this->json('PUT', '/api/v1/steam-market-csgo-items/' . $item->hash_name, $formData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => $formData + $item->toArray()
            ]);
    }

    public function test_unauthorized_user_cannot_update_item()
    {
        $item = SteamMarketCsgoItem::factory()->create();

        $formData = [
            'volume'    => $this->faker()->numberBetween(0, 100),
            'price'     => $this->faker()->randomFloat(2, 0 ,100)
        ];

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('PUT', '/api/v1/steam-market-csgo-items/' . $item->hash_name, $formData);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    public function test_authorized_user_can_delete_item()
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:delete']
        );

        $response = $this->json('DELETE', '/api/v1/steam-market-csgo-items/' . $item->hash_name);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success'   => true,
                'data'      => $item->toArray()
            ]);
    }

    public function test_unauthorized_user_cannot_delete_item()
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('DELETE', '/api/v1/steam-market-csgo-items/' . $item->hash_name);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success'       => false,
                'error_message' => 'unauthorized'
            ]);
    }

    public function postItemDataProvider()
    {
        return [
            [
                [
                    'hash_name'     => 'AK-47 | Asiimov (Field-Tested)',
                    'volume'        => 100,
                    'price'         => 77.77,
                    'icon'          => '-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpot7HxfDhjxszJemkV092lnYmGmOHLPr7Vn35cppQiiOuQpoml3wW18xdkNTjxd9CQdwM_ZlrT-lW_kLzu0560vp-azXJ9-n51Q5-Fea0',
                    'icon_large'    => '-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpot7HxfDhjxszJemkV092lnYmGmOHLPr7Vn35c18lwmO7Eu92milbl-BZsZGiiLNKdJFc8Mg7V_1S_xuzshZK97c_In3pruCJx4X_D30vgyZM--n4',
                    'name_color'    => '#D2D2D2',
                    'type'          => 'Covert Rifle',
                    'collection'    => 'The Danger Zone Collection'
                ]
            ]
        ];
    }
}
