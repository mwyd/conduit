<?php

namespace App\Http\Validation;

use Illuminate\Validation\Rule;

trait HasOrderRules
{
    protected function orderRules(array $orderBy): array
    {
        return [
            'order_by' => ['sometimes', Rule::in($orderBy)],
            'order_dir' => ['sometimes', Rule::in(['desc', 'asc'])],
        ];
    }
}
