<?php

namespace App\Http\Filters\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait HasPaginationFilter
{
    protected int $defaultLimit = 50;

    public function offset(Builder $builder, ?int $value): void
    {
        $builder->offset($value ?? 0);
    }

    public function limit(Builder $builder, ?int $value): void
    {
        $builder->limit($value ?? $this->defaultLimit);
    }
}
