<?php

namespace App\Http\Filters;

use App\Http\Requests\Api\V1\IndexSteamMarketCsgoItemRequest;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSteamMarketCsgoItemFilter;

class SteamMarketCsgoItemFilter extends Filter
{
    use HasSteamMarketCsgoItemFilter, HasSearchFilter, HasOrderFilter, HasPaginationFilter;

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
}