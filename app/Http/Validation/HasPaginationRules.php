<?php

namespace App\Http\Validation;

trait HasPaginationRules
{
    protected function paginationRules()
    {
        return [
            'offset'    => 'sometimes|integer|min:0',
            'limit'     => 'sometimes|integer|between:1,50'
        ];
    }
}