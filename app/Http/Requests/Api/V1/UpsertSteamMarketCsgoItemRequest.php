<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertSteamMarketCsgoItemRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'hash_name'     => 'required|string',
            'volume'        => 'required|integer',
            'price'         => 'required|numeric',
            'icon'          => 'required|string',
            'icon_large'    => 'sometimes|nullable',
            'name_color'    => 'required|string',
            'type'          => 'required|string',
            'phase'         => 'sometimes|nullable',
            'collection'    => 'sometimes|nullable'
        ];

        if($this->method() == self::METHOD_PUT) 
        {
            foreach($rules as $key => $rule) $rules[$key] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}
