<?php

namespace App\Models;

use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShadowpayWeeklySoldItem extends Model
{
    use HasFactory, HasSerializedDate;

    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'integer',
        'price' => 'float'
    ];

    public function scopeOutdated(Builder $builder): void
    {
        $builder->where('sold_at', '<', now()->modify('-7 days'));
    }
}
