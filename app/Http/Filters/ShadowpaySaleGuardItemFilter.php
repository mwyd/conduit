<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasSteamMarketCsgoItemFilter;
use App\Http\Requests\Api\V1\IndexShadowpaySaleGuardItemRequest;

class ShadowpaySaleGuardItemFilter extends Filter
{
    use HasSteamMarketCsgoItemFilter, HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexShadowpaySaleGuardItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'hash_name';

        $this->steamMarketCsgoItemRelation = true;

        $this->defaultFilters = [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'created_at',
            'oder_dir'  => 'desc'
        ];
    }
}