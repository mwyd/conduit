<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexBuffMarketCsgoItemRequest extends FormRequest
{
    use HasSearchRules, HasOrderRules, HasPaginationRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->searchRules(),
            ...$this->orderRules([
                'hash_name',
                'updated_at',
                'volume',
                'price',
                'good_id',
            ]),
            ...$this->paginationRules(),
        ];
    }
}
