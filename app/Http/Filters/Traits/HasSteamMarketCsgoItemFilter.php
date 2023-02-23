<?php

namespace App\Http\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSteamMarketCsgoItemFilter
{
    protected bool $steamMarketCsgoItemRelation = false;

    public function isStattrak(Builder $builder, bool $value): void
    {
        if ($this->steamMarketCsgoItemRelation) {
            $builder->whereHas('steamMarketCsgoItem', fn ($q) => $q->where('is_stattrak', $value));
        } else {
            $builder->where('is_stattrak', $value);
        }
    }

    public function exteriors(Builder $builder, array $value): void
    {
        if ($this->steamMarketCsgoItemRelation) {
            $builder->whereHas('steamMarketCsgoItem', fn ($q) => $q->whereIn('exterior', $value));
        } else {
            $builder->whereIn('exterior', $value);
        }
    }

    public function tags(Builder $builder, array $value): void
    {
        $tags = array_map(fn ($tag) => ['type', 'like', "%$tag%"], $value);

        if ($this->steamMarketCsgoItemRelation) {
            $builder->whereHas('steamMarketCsgoItem', fn ($q) => $q->where($tags));
        } else {
            $builder->where($tags);
        }
    }
}
