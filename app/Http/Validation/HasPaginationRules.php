<?php

namespace App\Http\Validation;

trait HasPaginationRules
{
    protected function paginationRules(): array
    {
        return [
            'offset' => 'sometimes|integer|min:0',
            'limit' => 'sometimes|integer|between:1,1000',
        ];
    }
}
