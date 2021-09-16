<?php

namespace App\Http\Filters\Traits;

trait HasOrderFilter
{
    public function orderBy($value)
    {
        $this->builder->orderBy($value, $this->filters()['order_dir'] ?? 'asc');
    }
}