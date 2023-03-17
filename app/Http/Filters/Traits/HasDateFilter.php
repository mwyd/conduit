<?php

namespace App\Http\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;

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
