<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySaleGuardItem extends Model
{
    use HasFactory, HasApiFilters;

    protected $hidden = [
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'hash_name',
        'shadowpay_offer_id',
        'min_price',
        'max_price'
    ];

    protected $casts = [
        'shadowpay_offer_id'    => 'integer',
        'min_price'             => 'float',
        'max_price'             => 'float'
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

        return $query->apiFilter($params);
    }
}
