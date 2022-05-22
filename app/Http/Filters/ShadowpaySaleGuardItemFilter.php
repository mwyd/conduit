<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasSteamMarketCsgoItemFilter;

class ShadowpaySaleGuardItemFilter extends AbstractFilter
{
    use HasSteamMarketCsgoItemFilter, HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->orderDir = 'desc';

        $this->steamMarketCsgoItemRelation = true;

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'created_at'
        ];
    }
}
