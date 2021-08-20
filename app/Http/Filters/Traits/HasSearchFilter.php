<?php

namespace App\Http\Filters\Traits;

trait HasSearchFilter
{
    protected $searchColumn;
    
    public function search($value)
    {
        $this->builder->where($this->searchColumn, 'like', "%{$value}%");
    }
}