<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexCsgoBlueGemItemRequest extends FormRequest
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
            'paint_seed'    => 'sometimes|integer',
            'gem_type'      => ['sometimes', Rule::in([
                'blue', 
                'gold', 
                'tier 2', 
                'tier 3'
            ])],
            'order_by'      => ['sometimes', Rule::in([
                'updated_at', 
                'item_type', 
                'paint_seed'
            ])]
        ];
    }
}
