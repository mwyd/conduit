<?php

namespace App\Http\Validation;

trait HasSearchRules
{
    protected function searchRules(): array
    {
        return [
            'search' => 'sometimes|nullable|string',
        ];
    }
}
