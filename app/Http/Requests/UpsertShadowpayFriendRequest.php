<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpayFriendRequest extends FormRequest
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
            'name'          => 'required|string',
            'shadowpay_id'  => 'required|integer'
        ];

        if($this->method() == self::METHOD_PUT)
        {
            foreach($rules as $key => $rule) $rules[$key] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}
