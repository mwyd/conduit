<?php

namespace App\Http\Filters;

use App\Http\Requests\Api\V1\IndexBuffMarketCsgoItemRequest;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;

class BuffMarketCsgoItemFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexBuffMarketCsgoItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'hash_name';

        $this->defaultFilters = [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'good_id',
            'order_dir' => 'asc'
        ];
    }
}