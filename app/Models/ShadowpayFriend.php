<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayFriend extends Model
{
    use HasFactory, HasApiFilters;

    protected $hidden = [
        'user_id',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'shadowpay_user_id',
        'user_id'
    ];

    protected $casts = [
        'shadowpay_user_id'     => 'integer'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, $params)
    {
        $params = $params + [
            'order_by'  => 'name',
            'order_dir' => 'asc'
        ];

        return $query->apiFilters($params);
    }
}
