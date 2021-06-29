<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexShadowpaySoldItemRequest extends FormRequest
{
    use ApiValidationTrait;

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
        return $this->apiPaginationRules() + [
            'date_start'    => 'sometimes|date',
            'date_end'      => 'sometimes|date',
            'price_from'    => 'sometimes|numeric',
            'price_to'      => 'sometimes|numeric',
            'min_sold'      => 'sometimes|integer',
            'max_sold'      => 'sometimes|integer',
            'order_by'      => ['sometimes', Rule::in([
                'hash_name',
                'sold', 
                'avg_discount', 
                'avg_sell_price', 
                'avg_steam_price', 
                'last_sold'
            ])]
        ];
    }
}
