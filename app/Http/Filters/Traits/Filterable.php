<?php

namespace App\Http\Filters\Traits;

use App\Http\Filters\Filter;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }
}