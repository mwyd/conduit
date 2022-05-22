<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    protected array $defaultFilters = [];

    public function apply(Builder $builder, array $params): Builder
    {
        $filters = [...$this->defaultFilters, ...$params];

        foreach ($filters as $name => $value) {
            $name = Str::camel($name);

            if (!method_exists($this, $name)) {
                continue;
            }

            $this->$name($builder, $value);
        }

        return $builder;
    }
}
