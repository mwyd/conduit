<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpaySoldItemRequest extends FormRequest
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
            'transaction_id'    => 'required|string',
            'hash_name'         => 'required|string',
            'discount'          => 'required|integer',
            'sell_price'        => 'sometimes|nullable|numeric',
            'steam_price'       => 'sometimes|nullable|numeric',
            'sold_at'           => 'required|date'
        ];

        if($this->method() == self::METHOD_PUT) 
        {
            foreach($rules as $key => $rule) $rules[$key] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}
