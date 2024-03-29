<?php

namespace App\Http\Filters;

use App\Http\Filters\Traits\HasOrderFilter;
use App\Http\Filters\Traits\HasPaginationFilter;
use App\Http\Filters\Traits\HasSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class SteamMarketCsgoItemFilter extends AbstractFilter
{
    use HasOrderFilter, HasPaginationFilter, HasSearchFilter;

    public function __construct()
    {
        $this->searchColumn = 'hash_name';

        $this->orderDir = 'desc';

        $this->defaultFilters = [
            'offset' => null,
            'limit' => null,
            'order_by' => 'volume',
        ];
    }

    public function isStattrak(Builder $builder, bool $value): void
    {
        $builder->where('is_stattrak', $value);
    }

    public function isSouvenir(Builder $builder, bool $value): void
    {
        $builder->where('is_souvenir', $value);
    }

    public function exteriors(Builder $builder, array $value): void
    {
        $builder->whereIn('exterior', $value);
    }

    public function tags(Builder $builder, array $value): void
    {
        $tags = array_map(fn ($tag) => ['type', 'like', "%$tag%"], $value);

        $builder->where($tags);
    }
}
