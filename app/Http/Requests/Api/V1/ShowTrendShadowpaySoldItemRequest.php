<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasDateRules;
use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use Illuminate\Foundation\Http\FormRequest;

class ShowTrendShadowpaySoldItemRequest extends FormRequest
{
    use HasDateRules, HasOrderRules, HasPaginationRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->dateRules(),
            ...$this->orderRules(['date']),
            ...$this->paginationRules()
        ];
    }
}
