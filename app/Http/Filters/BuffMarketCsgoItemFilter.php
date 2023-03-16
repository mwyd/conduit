<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;

class BuffMarketCsgoItemFilter extends AbstractFilter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'good_id'
        ];
    }
}