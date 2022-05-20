<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use App\Http\Validation\HasSteamMarketCsgoItemRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexSteamMarketCsgoItemRequest extends FormRequest
{
    use HasSteamMarketCsgoItemRules, HasSearchRules, HasOrderRules, HasPaginationRules;

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
            ...$this->steamMarketCsgoItemRules(),
            ...$this->searchRules(),
            ...$this->orderRules([
                'hash_name',
                'updated_at',
                'volume',
                'price'
            ]),
            ...$this->paginationRules()
        ];
    }
}
