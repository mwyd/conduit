<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasDateRules;
use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use App\Http\Validation\HasSteamMarketCsgoItemRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpaySoldItemRequest extends FormRequest
{
    use HasSteamMarketCsgoItemRules, HasSearchRules, HasDateRules, HasOrderRules, HasPaginationRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareSteamMarketCsgoItemRules($this);
    }

    public function rules(): array
    {
        return [
            'price_from' => 'sometimes|numeric',
            'price_to' => 'sometimes|numeric',
            'min_sold' => 'sometimes|integer',
            'max_sold' => 'sometimes|integer',
            ...$this->steamMarketCsgoItemRules(),
            ...$this->searchRules(),
            ...$this->dateRules(),
            ...$this->orderRules([
                'hash_name',
                'sold',
                'avg_discount',
                'avg_suggested_price',
                'avg_steam_price',
                'last_sold'
            ]),
            ...$this->paginationRules()
        ];
    }
}
