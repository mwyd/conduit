<?php

namespace App\Http\Traits;

use Illuminate\Validation\Rule;

trait HasApiValidation
{
    /**
     * Get the base rules that apply to api index request.
     *
     * @param  array  $options
     * @return  array
     */
    private function apiValidationRules($options = [])
    {
        $rules = [
            'offset'    => 'sometimes|integer|min:0',
            'limit'     => 'sometimes|integer|between:1,50'
        ];

        if(isset($options['order_by']))
        {
            $rules['order_by']  = ['sometimes', Rule::in($options['order_by'])];
            $rules['order_dir'] = ['sometimes', Rule::in(['desc', 'asc'])];
        }

        if($options['use_search'] ?? false)
        {
            $rules['search'] = 'sometimes|nullable|string';
        }

        if($options['use_date'] ?? false)
        {
            $rules['date_start'] = 'sometimes|date';
            $rules['date_end']  = 'sometimes|date';
        }

        return $rules;
    }
}