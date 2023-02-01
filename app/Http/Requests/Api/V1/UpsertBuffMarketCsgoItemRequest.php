<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertBuffMarketCsgoItemRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'hash_name' => 'required|string',
            'volume' => 'required|integer',
            'price' => 'required|numeric',
            'good_id' => 'required|integer'
        ];

        if ($this->method() == self::METHOD_PUT) {
            unset($rules['hash_name']);

            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'sometimes', $rule);
            }
        }

        return $rules;
    }
}
