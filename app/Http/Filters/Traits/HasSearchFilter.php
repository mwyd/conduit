<?php

namespace App\Http\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearchFilter
{
    protected string $searchColumn;

    public function search(Builder $builder, string $value): void
    {
        $builder->where($this->searchColumn, 'like', "%{$value}%");
    }
}
