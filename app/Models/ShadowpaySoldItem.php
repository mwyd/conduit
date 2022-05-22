<?php

namespace App\Models;

use App\Http\Filters\ShadowpaySoldItemFilter;
use App\Http\Filters\ShadowpaySoldItemTrendFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShadowpaySoldItem extends Model
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
        'sold_at'
    ];

    protected $casts = [
        'discount' => 'integer',
        'suggested_price' => 'float',
        'steam_price' => 'float',
        'avg_discount' => 'float',
        'avg_suggested_price' => 'float',
        'avg_sell_price' => 'float',
        'avg_steam_price' => 'float'
    ];

    public function steamMarketCsgoItem(): BelongsTo
    {
        return $this->belongsTo(SteamMarketCsgoItem::class, 'hash_name');
    }

    public function scopeRawItem(Builder $builder, array $params): Builder
    {
        return (new ShadowpaySoldItemFilter())
            ->apply($builder, $params)
            ->selectRaw(
                'hash_name, ' .
                'count(hash_name) as sold, ' .
                'round(avg(discount), 2) as avg_discount, ' .
                'round(avg(suggested_price), 2) as avg_suggested_price, ' .
                'round(avg(steam_price), 2) as avg_steam_price, ' .
                'max(sold_at) as last_sold'
            );
    }

    public function scopeRawTrend(Builder $builder, array $params): Builder
    {
        return (new ShadowpaySoldItemTrendFilter())
            ->apply($builder, $params)
            ->selectRaw(
                'date(sold_at) as date, ' .
                'count(hash_name) as sold, ' .
                'round(avg(suggested_price) * avg((100 - discount) / 100), 2) as avg_sell_price, ' .
                'round(avg(steam_price), 2) as avg_steam_price'
            );
    }
}
