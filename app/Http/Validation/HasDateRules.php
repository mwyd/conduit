<?php

namespace App\Http\Validation;

trait HasDateRules
{
    protected function dateRules(): array
    {
        return [
            'date_start' => 'sometimes|date',
            'date_end' => 'sometimes|date',
        ];
    }
}
