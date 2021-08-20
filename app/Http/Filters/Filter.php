<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter
{
    protected $request;

    protected $filters;

    protected $builder;

    public function __construct(Request $request)
    {   
        $this->request = $request;
        $this->filters = $request->validated();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->filters as $name => $value)
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
}