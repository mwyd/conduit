<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Requests\Api\V1\IndexShadowpayFriendRequest;

class ShadowpayFriendFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexShadowpayFriendRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'name';

        $this->filters += [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'name',
            'oder_dir'  => 'asc'
        ];
    }
}