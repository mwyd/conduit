<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;

class BuffMarketCsgoItemFilter extends AbstractFilter
{
    use HasOrderFilter, HasPaginationFilter, HasSearchFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'good_id',
        ];
    }
}
