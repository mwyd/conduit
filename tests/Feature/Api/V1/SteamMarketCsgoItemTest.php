<?php

namespace Tests\Feature\Api\V1;

use App\Models\SteamMarketCsgoItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SteamMarketCsgoItemTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_index_request_returns_valid_data(): void
    {
        $items = SteamMarketCsgoItem::factory()
            ->count(20)
            ->create()
            ->toArray();

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => usort($items, function ($a, $b) {
                    return $a['volume'] - $b['volume'];
                }),
            ]);
    }

    public function test_single_request_returns_valid_data(): void
    {
        $item = SteamMarketCsgoItem::factory()->create();

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items/'.$item->hash_name);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $item->toArray(),
            ]);
    }

    public function test_single_request_returns_not_found(): void
    {
        $hashName = $this->faker()->words(3, true);

        $response = $this->json('GET', '/api/v1/steam-market-csgo-items/'.$hashName);

        $response
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error_message' => 'not_found',
            ]);
    }

    #[DataProvider('createItemDataProvider')]
    public function test_authorized_user_can_create_item($formData): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['api:post']
        );

        $response = $this->json('POST', '/api/v1/steam-market-csgo-items', $formData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => $formData,
            ]);
    }

    #[DataProvider('createItemDataProvider')]
    public function test_unauthorized_user_cannot_create_item($formData): void
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('POST', '/api/v1/steam-market-csgo-items', $formData);

        $response
            ->assertStatus(403)
            ->assertJson([
                'success' => false,
                'error_message' => 'forbidden',
            ]);
    }

    #[DataProvider('updateItemDataProvider')]
    public function test_authorized_user_can_update_item($formData): void
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:put']
        );

        $response = $this->json('PUT', '/api/v1/steam-market-csgo-items/'.$item->hash_name, $formData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $formData + $item->toArray(),
            ]);
    }

    #[DataProvider('updateItemDataProvider')]
    public function test_unauthorized_user_cannot_update_item($formData): void
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('PUT', '/api/v1/steam-market-csgo-items/'.$item->hash_name, $formData);

        $response
            ->assertStatus(403)
            ->assertJson([
                'success' => false,
                'error_message' => 'forbidden',
            ]);
    }

    public function test_authorized_user_can_delete_item(): void
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['api:delete']
        );

        $response = $this->json('DELETE', '/api/v1/steam-market-csgo-items/'.$item->hash_name);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => $item->toArray(),
            ]);
    }

    public function test_unauthorized_user_cannot_delete_item(): void
    {
        $item = SteamMarketCsgoItem::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->json('DELETE', '/api/v1/steam-market-csgo-items/'.$item->hash_name);

        $response
            ->assertStatus(403)
            ->assertJson([
                'success' => false,
                'error_message' => 'forbidden',
            ]);
    }

    public static function createItemDataProvider(): array
    {
        return [
            'valid data' => [
                [
                    'hash_name' => 'AK-47 | Asiimov (Field-Tested)',
                    'volume' => 100,
                    'price' => 77.77,
                    'icon' => '-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpot7HxfDhjxszJemkV092lnYmGmOHLPr7Vn35cppQiiOuQpoml3wW18xdkNTjxd9CQdwM_ZlrT-lW_kLzu0560vp-azXJ9-n51Q5-Fea0',
                    'icon_large' => '-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpot7HxfDhjxszJemkV092lnYmGmOHLPr7Vn35c18lwmO7Eu92milbl-BZsZGiiLNKdJFc8Mg7V_1S_xuzshZK97c_In3pruCJx4X_D30vgyZM--n4',
                    'name_color' => '#D2D2D2',
                    'type' => 'Covert Rifle',
                    'collection' => 'The Danger Zone Collection',
                ],
            ],
        ];
    }

    public static function updateItemDataProvider(): array
    {
        return [
            'valid data' => [
                [
                    'volume' => 21,
                    'price' => 25.71,
                ],
            ],
        ];
    }
}
