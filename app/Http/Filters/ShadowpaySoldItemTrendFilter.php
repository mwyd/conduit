<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use Carbon\Carbon;

class ShadowpaySoldItemTrendFilter extends AbstractFilter
{
    use HasDateFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->dateColumn = 'sold_at';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'date',
            'date_start' => Carbon::now()->subWeek()
        ];
    }
}
