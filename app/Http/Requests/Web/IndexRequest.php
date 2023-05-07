<?php

namespace App\Http\Requests\Web;

use App\Http\Validation\HasDateRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use HasSearchRules, HasDateRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price_from' => 'sometimes|numeric',
            'price_to' => 'sometimes|numeric',
            'quantity_from' => 'sometimes|integer',
            'quantity_to' => 'sometimes|integer',
            'is_stattrak' => 'sometimes|boolean',
            'exteriors' => 'sometimes|array|max:5',
            ...$this->searchRules(),
            ...$this->dateRules(),
        ];
    }
}
