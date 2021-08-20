<?php

namespace App\Http\Filters\Traits;

trait HasPaginationFilter
{
    public function offset($value)
    {
        $this->builder->offset($value ?? 0);
    }

    public function limit($value)
    {
        $this->builder->limit($value ?? 50);
    }
}