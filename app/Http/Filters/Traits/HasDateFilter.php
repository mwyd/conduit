<?php

namespace App\Http\Filters\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait HasDateFilter
{
    protected string $dateColumn;

    public function dateStart(Builder $builder, string $value): void
    {
        $builder->where($this->dateColumn, '>=', $value);
    }

    public function dateEnd(Builder $builder, string $value): void
    {
        $builder->where($this->dateColumn, '<=', $value);
    }
}
