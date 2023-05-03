<?php

namespace Tests\Integration\Api;

use App\Api\NbpApi;
use Tests\TestCase;

class NbpApiTest extends TestCase
{
    private ?NbpApi $nbpApi;

    public function test_nbp_api_returns_valid_exchange_rate(): void
    {
        $exchangeRate = $this->nbpApi->getPlnExchangeRate('USD');

        $this->assertIsFloat($exchangeRate);
    }

    public function test_nbp_api_returns_invalid_exchange_rate(): void
    {
        $exchangeRate = $this->nbpApi->getPlnExchangeRate('INVALID_ISO');

        $this->assertNull($exchangeRate);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->nbpApi = new NbpApi();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->nbpApi = null;
    }
}
