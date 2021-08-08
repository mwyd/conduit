<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoBlueGemItem extends Model
{
    use HasFactory, HasApiFilters;

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'item_type',
        'paint_seed',
        'gem_type'
    ];

    protected $casts = [
        'paint_seed'    => 'integer'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, $params)
    {
        $params = $params + [
            'order_by'  => 'paint_seed',
            'order_dir' => 'desc'
        ];

        if(isset($params['paint_seed']))
        {
            $query = $query->where('paint_seed', $params['paint_seed']);
        }

        if(isset($params['gem_type']))
        {
            $query = $query->$query->where('gem_type', $params['get_type']);
        }

        return $query->apiFilter($params, [
            'search_column' => 'item_type'
        ]);
    }
}
