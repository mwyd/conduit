<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Traits\HasApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class IndexSteamMarketCsgoItemRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $params = [];

        if($this->stattrak)
        {
            $params['stattrak'] = boolval($this->stattrak);
        }

        if($this->exteriors)
        {
            $params['exteriors'] = explode(',', $this->exteriors);
        }

        if($this->types)
        {
            $params['types'] = explode(',', $this->types);
        }

        $this->merge($params);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->apiValidationRules([
            'use_search'    => true,
            'order_by'      => [
                'hash_name',
                'updated_at', 
                'volume', 
                'price'
            ]
        ]);

        return $rules + [
            'stattrak'  => 'sometimes|boolean',
            'exteriors' => 'sometimes|array',
            'types'     => 'sometimes|array'
        ];
    }
}
