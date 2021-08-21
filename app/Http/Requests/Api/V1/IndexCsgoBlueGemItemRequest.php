<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexCsgoBlueGemItemRequest extends FormRequest
{
    use HasSearchRules, HasOrderRules, HasPaginationRules;

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
        return [
            'paint_seed'    => 'sometimes|integer',
            'gem_type'      => ['sometimes', Rule::in([
                'blue', 
                'gold', 
                'tier 2', 
                'tier 3'
            ])]
        ]
        + $this->searchRules()
        + $this->orderRules([
            'updated_at', 
            'item_type', 
            'paint_seed'
        ])
        + $this->paginationRules();
    }
}
