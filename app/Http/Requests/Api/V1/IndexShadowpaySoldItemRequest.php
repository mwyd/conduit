<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Traits\HasApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpaySoldItemRequest extends FormRequest
{
    use HasApiValidation;

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
        $rules = $this->apiValidationRules([
            'use_date'      => true,
            'use_search'    => true,
            'order_by'      => [
                'hash_name',
                'sold', 
                'avg_discount', 
                'avg_suggested_price', 
                'avg_steam_price', 
                'last_sold'
            ]
        ]);

        return $rules + [
            'price_from'    => 'sometimes|numeric',
            'price_to'      => 'sometimes|numeric',
            'min_sold'      => 'sometimes|integer',
            'max_sold'      => 'sometimes|integer'
        ];
    }
}
