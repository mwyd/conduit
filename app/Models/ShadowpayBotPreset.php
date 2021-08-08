<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotPreset extends Model
{
    use HasFactory, HasApiFilters;

    protected $hidden = [
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'preset'
    ];

    protected $casts = [
        'preset' => 'array'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function scopeFilter($query, $params)
    {
        $params = $params + [
            'order_by'  => 'updated_at',
            'order_dir' => 'desc'
        ];

        return $query->apiFilter($params);
    }
}
