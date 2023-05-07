<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShadowpaySoldItemFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySoldItem extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'transaction_id',
        'hash_name',
        'discount',
        'suggested_price',
        'steam_price',
        'sold_at',
    ];

    protected $casts = [
        'discount' => 'integer',
        'suggested_price' => 'float',
        'steam_price' => 'float',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new ShadowpaySoldItemFilter())->apply($builder, $params);
    }
}
