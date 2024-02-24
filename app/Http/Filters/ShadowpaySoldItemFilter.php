<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;

class ShadowpaySoldItemFilter extends AbstractFilter
{
    use HasDateFilter, HasOrderFilter, HasPaginationFilter, HasSearchFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->dateColumn = 'sold_at';

        $this->orderDir = 'desc';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'sold_at',
        ];
    }
}
