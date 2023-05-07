<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;

class ShadowpayFriendFilter extends AbstractFilter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->searchColumn = 'name';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'name',
        ];
    }
}
