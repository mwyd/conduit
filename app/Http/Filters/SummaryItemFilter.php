<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasSearchFilter;
use Illuminate\Contracts\Database\Query\Builder;

class SummaryItemFilter extends AbstractFilter
{
    use HasSearchFilter;

    public function __construct()
    {
        $this->searchColumn = 'sp.hash_name';
    }

    public function priceFrom(Builder $builder, float $value): void
    {
        $builder->where('sp.price', '>=', $value);
    }

    public function priceTo(Builder $builder, float $value): void
    {
        $builder->where('sp.price', '<=', $value);
    }

    public function quantityFrom(Builder $builder, int $value): void
    {
        $builder->where('sp.sold', '>=', $value);
    }

    public function quantityTo(Builder $builder, int $value): void
    {
        $builder->where('sp.sold', '<=', $value);
    }

    public function isStattrak(Builder $builder, bool $value): void
    {
        $builder->where('sm.is_stattrak', $value);
    }

    public function isSouvenir(Builder $builder, bool $value): void
    {
        $builder->where('sm.is_souvenir', $value);
    }

    public function exteriors(Builder $builder, array $value): void
    {
        $builder->whereIn('sm.exterior', $value);
    }
}
