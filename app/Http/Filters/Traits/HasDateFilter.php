<?php

namespace App\Http\Filters\Traits;

trait HasDateFilter
{
    protected $dateColumn;

    public function dateStart($value)
    {
        $this->builder->whereDate($this->dateColumn, '>=', $value);
    }

    public function dateEnd($value)
    {
        $this->builder->whereDate($this->dateColumn, '<=', $value);
    }
}