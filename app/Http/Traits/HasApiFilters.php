<?php

namespace App\Http\Traits;

trait HasApiFilters
{
    public function scopeApiFilter($query, $params, $options = [])
    {
        if(isset($params['search']) && isset($options['search_column']))
        {
            $query = $query->where($options['search_column'], 'like', '% ' . $params['search'] . '%');
        }

        if(isset($params['order_by']))
        {
            $query = $query->orderBy($params['order_by'], $params['order_dir'] ?? 'desc');
        }

        if(isset($options['date_column']))
        {
            if(isset($params['date_start']))
            {
                $query = $query->whereDate($options['date_column'], '>=', $params['date_start']);
            }

            if(isset($params['date_end']))
            {
                $query = $query->whereDate($options['date_column'], '<=', $params['date_end']);
            }
        }

        return $query
                ->offset($params['offset'] ?? 0)
                ->limit($params['limit'] ?? 50);
    }
}