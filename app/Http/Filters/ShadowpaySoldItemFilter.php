<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasSteamMarketCsgoItemFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ShadowpaySoldItemFilter extends AbstractFilter
{
    use HasSteamMarketCsgoItemFilter, HasSearchFilter, HasDateFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';
        $this->dateColumn = 'sold_at';

        $this->orderDir = 'desc';

        $this->steamMarketCsgoItemRelation = true;

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'sold',
            'date_start' => Carbon::now()->subWeek()
        ];
    }

    public function priceFrom(Builder $builder, float $value): void
    {
        $builder->having('avg_steam_price', '>=', $value);
    }

    public function priceTo(Builder $builder, float $value): void
    {
        $builder->having('avg_steam_price', '<=', $value);
    }

    public function minSold(Builder $builder, int $value): void
    {
        $builder->having('sold', '>=', $value);
    }

    public function maxSold(Builder $builder, int $value): void
    {
        $builder->having('sold', '<=', $value);
    }
}
