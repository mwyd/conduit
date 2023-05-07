<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertSteamMarketCsgoItemRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'hash_name' => 'required|string|unique:steam_market_csgo_items',
            'volume' => 'required|integer',
            'price' => 'required|numeric',
            'icon' => 'required|string',
            'icon_large' => 'sometimes|nullable',
            'name_color' => 'required|string',
            'type' => 'required|string',
            'phase' => 'sometimes|nullable',
            'collection' => 'sometimes|nullable',
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
