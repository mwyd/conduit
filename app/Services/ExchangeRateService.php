<?php

namespace App\Services;

use App\Api\NbpApi;

class ExchangeRateService
{
    public function __construct(
        private readonly NbpApi $nbpApi
    ) {}

    public function getExchangeRate(string $from, string $to): ?float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from == $to) {
            return 1;
        }

        $fromRate = $this->nbpApi->getPlnExchangeRate($from);
        $toRate = $this->nbpApi->getPlnExchangeRate($to);

        if ($fromRate === null || $toRate === null) {
            return null;
        }

        return $fromRate / $toRate;
    }
}
