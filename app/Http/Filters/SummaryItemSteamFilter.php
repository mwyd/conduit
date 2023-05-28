<?php

namespace App\Http\Filters;

use Illuminate\Contracts\Database\Query\Builder;

class SummaryItemSteamFilter extends AbstractFilter
{
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
}
