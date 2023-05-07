<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexSteamMarketCsgoItemRequest extends FormRequest
{
    use HasSearchRules, HasOrderRules, HasPaginationRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $params = [];

        if ($this->has('is_stattrak')) {
            $params['is_stattrak'] = $this->boolean('is_stattrak');
        }

        if ($this->has('exteriors')) {
            $params['exteriors'] = explode(',', $this->input('exteriors'));
        }

        if ($this->has('tags')) {
            $params['tags'] = explode(',', $this->input('tags'));
        }

        $this->merge($params);
    }

    public function rules(): array
    {
        return [
            'is_stattrak' => 'sometimes|boolean',
            'exteriors' => 'sometimes|array|max:5',
            'tags' => 'sometimes|array|max:3',
            ...$this->searchRules(),
            ...$this->orderRules([
                'hash_name',
                'updated_at',
                'volume',
                'price',
            ]),
            ...$this->paginationRules(),
        ];
    }
}
