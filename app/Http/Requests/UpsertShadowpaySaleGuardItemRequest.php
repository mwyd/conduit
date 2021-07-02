<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpaySaleGuardItemRequest extends FormRequest
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
            'shadowpay_item_id' => 'required|numeric',
            'hash_name'         => 'required',
            'min_price'         => 'required|numeric',
            'max_price'         => 'required|numeric'
        ];

        if($this->method() == self::METHOD_PUT)
        {
            foreach($rules as $key => $rule) $rules[$key] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}
