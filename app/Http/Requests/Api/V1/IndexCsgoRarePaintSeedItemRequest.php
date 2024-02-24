<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexCsgoRarePaintSeedItemRequest extends FormRequest
{
    use HasOrderRules, HasPaginationRules, HasSearchRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paint_seed' => 'sometimes|integer',
            'variant' => 'sometimes|string',
            ...$this->searchRules(),
            ...$this->orderRules([
                'name',
                'paint_seed',
                'updated_at',
            ]),
            ...$this->paginationRules(),
        ];
    }
}
