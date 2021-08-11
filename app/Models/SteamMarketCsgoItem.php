<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamMarketCsgoItem extends Model
{
    use HasFactory, HasApiFilters;

    public $incrementing    = false;
    
    protected $keyType      = 'string';
    protected $primaryKey   = 'hash_name';

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'hash_name',
        'volume',
        'price',
        'icon',
        'is_stattrak',
        'name_color',
        'exterior',
        'type'
    ];

    protected $casts = [
        'volume'        => 'integer',
        'price'         => 'float',
        'is_stattrak'   => 'boolean'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, $params)
    {
        $params = $params + [
            'order_by'  => 'updated_at',
            'order_dir' => 'desc'
        ];

        return $query->apiFilter($params, [
            'search_column' => 'hash_name'
        ]);
    }
}
