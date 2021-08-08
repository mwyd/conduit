<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotConfig extends Model
{
    use HasFactory, HasApiFilters;

    protected $hidden = [
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'config'
    ];

    protected $casts = [
        'config' => 'array'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, $params)
    {
        $params = $params + [
            'order_by'  => 'updated_at',
            'oder_dir'  => 'desc'
        ];

        return $query->apiFilters($params);
    }
}
