<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShadowpaySaleGuardItemFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySaleGuardItem extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    protected $hidden = [
        'user_id',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'hash_name',
        'shadowpay_offer_id',
        'min_price',
        'max_price',
    ];

    protected $casts = [
        'shadowpay_offer_id' => 'integer',
        'min_price' => 'float',
        'max_price' => 'float',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new ShadowpaySaleGuardItemFilter())->apply($builder, $params);
    }
}
