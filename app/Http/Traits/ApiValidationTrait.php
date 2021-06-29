<?php

namespace App\Http\Traits;

use Illuminate\Validation\Rule;

trait ApiValidationTrait
{
    /**
     * Get the base rules that apply to api index request.
     *
     * @return array
     */
    private function apiPaginationRules()
    {
        return [
            'offset'        => 'sometimes|integer|min:0',
            'limit'         => 'sometimes|integer|between:1,50',
            'order_dir'     => ['sometimes', Rule::in(['desc', 'asc'])]
        ];
    }
}