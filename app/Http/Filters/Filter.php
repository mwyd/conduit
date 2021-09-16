<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter
{
    protected $request;

    protected $defaultFilters = [];

    protected $builder;

    public function __construct(Request $request)
    {   
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->filters() as $name => $value)
        {
            $name = Str::camel($name);

            if(!method_exists($this, $name)) continue;

            $this->$name($value);
        }

        return $this->builder;
    }

    public function request()
    {
        return $this->request;
    }

    public function filters()
    {
        return $this->request->validated() + $this->defaultFilters;
    }
}