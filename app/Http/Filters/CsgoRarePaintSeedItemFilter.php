<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class CsgoRarePaintSeedItemFilter extends AbstractFilter
{
    use HasSearchFilter, HasOrderFilter, HasPaginationFilter;

    public function __construct()
    {
        $this->searchColumn = 'name';

        $this->orderDir = 'desc';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'paint_seed'
        ];
    }

    public function paintSeed(Builder $builder, int $value): void
    {
        $builder->where('paint_seed', $value);
    }

    public function variant(Builder $builder, string $value): void
    {
        $builder->where('variant', $value);
    }
}
