<?php

namespace App\Http\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    protected array $defaultFilters = [];

    /**
     * @template T of Builder
     *
     * @param  T  $builder
     * @return T
     */
    public function apply(Builder $builder, array $params): Builder
    {
        $filters = [...$this->defaultFilters, ...$params];

        foreach ($filters as $name => $value) {
            $name = Str::camel($name);

            if (! method_exists($this, $name)) {
                continue;
            }

            $this->$name($builder, $value);
        }

        return $builder;
    }
}
