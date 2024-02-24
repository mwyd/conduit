<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use Illuminate\Contracts\Database\Query\Builder;

class SummaryItemShadowpayFilter extends AbstractFilter
{
    use HasDateFilter, HasSearchFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->dateColumn = 'sold_at';
    }

    public function priceFrom(Builder $builder, float $value): void
    {
        $builder->where('price', '>=', $value);
    }

    public function priceTo(Builder $builder, float $value): void
    {
        $builder->where('price', '<=', $value);
    }

    public function quantityFrom(Builder $builder, int $value): void
    {
        $builder->having('sold', '>=', $value);
    }

    public function quantityTo(Builder $builder, int $value): void
    {
        $builder->having('sold', '<=', $value);
    }
}
