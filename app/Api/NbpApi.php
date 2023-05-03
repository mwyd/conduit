<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

final class NbpApi
{
    private const URL = 'https://api.nbp.pl/api/exchangerates';

    public function getPlnExchangeRate(string $iso): ?float
    {
        $iso = strtoupper($iso);

        if ($iso == 'PLN') {
            return 1;
        }

        $response = Http::get(self::URL . "/rates/A/{$iso}?format=json");

        if (!$response->ok()) {
            return null;
        }

        return $response->json('rates.0.mid');
    }
}
