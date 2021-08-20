<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Requests\Api\V1\IndexShadowpaySoldItemRequest;
use Carbon\Carbon;

class ShadowpaySoldItemFilter extends Filter
{
    use HasSearchFilter, HasDateFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexShadowpaySoldItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'hash_name';
        $this->dateColumn = 'sold_at';

        $this->filters += [
            'offset'        => null,
            'limit'         => null,
            'order_by'      => 'sold',
            'order_dir'     => 'desc',
            'date_start'    => Carbon::now()->subWeek()
        ];
    }

    public function priceFrom($value)
    {
        $this->builder->having('avg_steam_price', '>=', $value);
    }

    public function priceTo($value)
    {
        $this->builder->having('avg_steam_price', '<=', $value);
    }

    public function minSold($value)
    {
        $this->builder->having('sold', '>=', $value);
    }

    public function maxSold($value)
    {
        $this->builder->having('sold', '<=', $value);
    }

    public function isStattrak($value)
    {
        $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->where('is_stattrak', $value));
    }

    public function exteriors($value)
    {
        $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->whereIn('exterior', $value));
    }

    public function types($value)
    {
        $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->whereIn('type', $value));
    }
}