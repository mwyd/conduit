<?php

namespace Tests\Integration\Api;

use App\Api\BuffApi;
use Tests\TestCase;

class BuffApiTest extends TestCase
{
    private ?BuffApi $buffApi;

    public function test_buff_api_sell_orders_returns_ok_response(): void
    {
        $response = $this->buffApi->getSellOrders(33959);

        $this->assertEquals(200, $response->status());

        ['code' => $code, 'data' => $data] = $response->json();

        $this->assertEquals('OK', $code);
        $this->assertIsArray($data['items']);
        $this->assertIsNumeric($data['items'][0]['price']);
        $this->assertIsInt($data['total_count']);
    }

    public function test_buff_api_sell_orders_returns_error_response(): void
    {
        $response = $this->buffApi->getSellOrders(0);

        $this->assertEquals(200, $response->status());

        ['code' => $code, 'error' => $error] = $response->json();

        $this->assertEquals('Invalid Argument', $code);
        $this->assertEquals('Not a valid id', $error);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->buffApi = new BuffApi;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->buffApi = null;
    }
}
