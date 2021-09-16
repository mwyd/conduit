<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Requests\Api\V1\IndexShadowpayBotPresetRequest;

class ShadowpayBotPresetFilter extends Filter
{
    use HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexShadowpayBotPresetRequest $request)
    {
        parent::__construct($request);

        $this->defaultFilters = [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'updated_at',
            'oder_dir'  => 'desc'
        ];
    }
}