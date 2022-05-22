<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

interface Filterable
{
    public function scopeFilter(Builder $builder, array $params): Builder;
}
