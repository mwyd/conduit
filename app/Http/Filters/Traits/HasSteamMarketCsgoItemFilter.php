<?php

namespace App\Http\Filters\Traits;

trait HasSteamMarketCsgoItemFilter
{
    protected $steamMarketCsgoItemRelation = false;

    public function isStattrak($value)
    {
        if($this->steamMarketCsgoItemRelation)
        {
            $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->where('is_stattrak', $value));
        }
        else
        {
            $this->builder->where('is_stattrak', $value);
        }
    }

    public function exteriors($value)
    {
        if($this->steamMarketCsgoItemRelation)
        {
            $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->whereIn('exterior', $value));
        }
        else
        {
            $this->builder->whereIn('exterior', $value);
        }
    }

    public function tags($value)
    {
        $tags = array_map(fn($tag) => ['type', 'like', "%$tag%"], $value);

        if($this->steamMarketCsgoItemRelation)
        {
            $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->where($tags));
        }
        else
        {
            $this->builder->where($tags);
        }
    }
}