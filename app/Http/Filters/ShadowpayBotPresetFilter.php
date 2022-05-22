<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;

class ShadowpayBotPresetFilter extends AbstractFilter
{
    use HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->orderDir = 'desc';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'updated_at'
        ];
    }
}
