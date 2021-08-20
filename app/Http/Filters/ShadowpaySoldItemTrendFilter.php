<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Requests\Api\V1\ShowTrendShadowpaySoldItemRequest;
use Carbon\Carbon;

class ShadowpaySoldItemTrendFilter extends Filter
{
    use HasDateFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(ShowTrendShadowpaySoldItemRequest $request)
    {
        parent::__construct($request);

        $this->dateColumn = 'sold_at';

        $this->filters += [
            'offset'        => null,
            'limit'         => null,
            'order_by'      => 'sold_at',
            'order_dir'     => 'asc',
            'date_start'    => Carbon::now()->subWeek()
        ];
    }
}