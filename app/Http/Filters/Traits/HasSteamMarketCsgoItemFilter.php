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

    public function types($value)
    {
        if($this->steamMarketCsgoItemRelation)
        {
            $this->builder->whereHas('steamMarketCsgoItem', fn($q) => $q->whereIn('type', $value));
        }
        else
        {
            $this->builder->whereIn('type', $value);
        }
    }
}