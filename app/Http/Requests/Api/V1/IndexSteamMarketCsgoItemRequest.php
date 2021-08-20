<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use App\Http\Validation\HasSteamMarketCsgoItemRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexSteamMarketCsgoItemRequest extends FormRequest
{
    use HasSteamMarketCsgoItemRules, HasSearchRules, HasOrderRules, HasPaginationRules;

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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->prepareSteamMarketCsgoItemRules($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->steamMarketCsgoItemRules()
        + $this->searchRules()
        + $this->orderRules([
            'hash_name',
            'updated_at', 
            'volume', 
            'price'  
        ])
        + $this->paginationRules();
    }
}
