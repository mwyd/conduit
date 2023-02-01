<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpaySoldItemRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'transaction_id' => 'required|string',
            'hash_name' => 'required|string',
            'discount' => 'required|integer',
            'suggested_price' => 'sometimes|nullable|numeric',
            'steam_price' => 'sometimes|nullable|numeric',
            'sold_at' => 'required|date'
        ];

        if ($this->method() == self::METHOD_PUT) {
            unset($rules['transaction_id']);

            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'sometimes', $rule);
            }
        }

        return $rules;
    }
}
