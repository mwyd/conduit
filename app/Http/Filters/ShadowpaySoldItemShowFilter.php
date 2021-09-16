<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasDateFilter;
use App\Http\Requests\Api\V1\ShowShadowpaySoldItemRequest;
use Carbon\Carbon;

class ShadowpaySoldItemShowFilter extends Filter
{
    use HasDateFilter;

    public function __construct(ShowShadowpaySoldItemRequest $request)
    {
        parent::__construct($request);

        $this->dateColumn = 'sold_at';

        $this->defaultFilters = [
            'date_start'    => Carbon::now()->subWeek()
        ];
    }
}