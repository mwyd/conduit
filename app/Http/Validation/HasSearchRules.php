<?php

namespace App\Http\Validation;

trait HasSearchRules
{
    protected function searchRules()
    {
        return [
            'search'    => 'sometimes|nullable|string'
        ];
    }
}