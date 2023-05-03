<?php

namespace App\Http\Filters\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait HasSearchFilter
{
    protected string $searchColumn;

    public function search(Builder $builder, string $value): void
    {
        $builder->where($this->searchColumn, 'like', "%{$value}%");
    }
}
