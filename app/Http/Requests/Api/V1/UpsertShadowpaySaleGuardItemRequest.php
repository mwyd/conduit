<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpaySaleGuardItemRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'shadowpay_offer_id' => 'required|integer',
            'hash_name' => 'required|string',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric'
        ];

        if ($this->method() == self::METHOD_PUT) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'sometimes', $rule);
            }
        }

        return $rules;
    }
}
