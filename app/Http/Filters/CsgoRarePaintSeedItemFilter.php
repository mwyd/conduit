<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Requests\Api\V1\IndexCsgoRarePaintSeedItemRequest;

class CsgoRarePaintSeedItemFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexCsgoRarePaintSeedItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'name';

        $this->defaultFilters = [
            'offset'    => null,
            'limit'     => null,
            'order_by'  => 'paint_seed',
            'order_dir' => 'desc'
        ];
    }

    public function paintSeed($value)
    {
        $this->builder->where('paint_seed', $value);
    }

    public function variant($value)
    {
        $this->builder->where('variant', $value);
    }
}