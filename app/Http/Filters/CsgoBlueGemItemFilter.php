<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use App\Http\Requests\Api\V1\IndexCsgoBlueGemItemRequest;

class CsgoBlueGemItemFilter extends Filter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct(IndexCsgoBlueGemItemRequest $request)
    {
        parent::__construct($request);

        $this->searchColumn = 'item_type';

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

    public function gemType($value)
    {
        $this->builder->where('gem_type', $value);
    }
}