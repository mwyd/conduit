<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Requests\Api\V1\IndexShadowpaySaleGuardItemRequest;

class ShadowpaySaleGuardItemFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexShadowpaySaleGuardItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'hash_name';

        $this->filters += [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'updated_at',
            'oder_dir'  => 'desc'
        ];
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