<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasDateRules;
use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpaySoldItemRequest extends FormRequest
{
    use HasDateRules, HasOrderRules, HasPaginationRules, HasSearchRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->searchRules(),
            ...$this->dateRules(),
            ...$this->orderRules(['sold_at']),
            ...$this->paginationRules(),
        ];
    }
}
