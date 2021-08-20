<?php

namespace App\Http\Filters;

use App\Http\Requests\Api\V1\IndexSteamMarketCsgoItemRequest;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;

class SteamMarketCsgoItemFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexSteamMarketCsgoItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'hash_name';

        $this->filters += [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'updated_at',
            'order_dir' => 'desc'
        ];
    }

    public function isStattrak($value)
    {
        $this->builder->where('is_stattrak', $value);
    }

    public function exteriors($value)
    {
        $this->builder->whereIn('exterior', $value);
    }

    public function types($value)
    {
        $this->builder->whereIn('type', $value);
    }
}