<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasDateRules;
use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use Illuminate\Foundation\Http\FormRequest;

class ShowTrendShadowpaySoldItemRequest extends FormRequest
{
    use HasDateRules, HasOrderRules, HasPaginationRules;

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
        return $this->dateRules()
        + $this->orderRules(['sold_at'])
        + $this->paginationRules();
    }
}
