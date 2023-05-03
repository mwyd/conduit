<?php

namespace App\Http\Filters\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait HasOrderFilter
{
    protected string $orderDir = 'asc';

    public function orderBy(Builder $builder, string $value): void
    {
        $builder->orderBy($value, request()->query('order_dir') ?? $this->orderDir);
    }
}
