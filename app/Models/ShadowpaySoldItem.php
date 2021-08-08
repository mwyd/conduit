<?php

namespace App\Models;

use App\Http\Traits\HasApiFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamMarketCsgoItem;
use Carbon\Carbon;

class ShadowpaySoldItem extends Model
{
    use HasFactory, HasApiFilters;

    public $incrementing    = false;
    public $timestamps      = false;
    
    protected $keyType      = 'string';
    protected $primaryKey   = 'transaction_id';

    protected $fillable = [
        'transaction_id',
        'hash_name',
        'discount',
        'suggested_price',
        'steam_price',
        'sold_at'
    ];

    protected $casts = [
        'discount'              => 'integer',
        'suggested_price'       => 'float',
        'steam_price'           => 'float',
        'avg_discount'          => 'float',
        'avg_suggested_price'   => 'float',
        'avg_sell_price'        => 'float',
        'avg_steam_price'       => 'float'
    ];

    public function steamMarketCsgoItem() 
    {
        return $this->belongsTo(SteamMarketCsgoItem::class, 'hash_name');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeRawItem($query)
    {
        return $query->selectRaw(
                'hash_name, ' .
                'count(hash_name) as sold, ' . 
                'round(avg(discount), 2) as avg_discount, ' . 
                'round(avg(suggested_price), 2) as avg_suggested_price, '. 
                'round(avg(steam_price), 2) as avg_steam_price, ' . 
                'max(sold_at) as last_sold'
            );
    }

    public function scopeRawTrend($query)
    {
        return $query->selectRaw(
                'date(sold_at) as date, ' .
                'count(hash_name) as sold, ' .
                'round(avg(suggested_price) * avg((100 - discount) / 100), 2) as avg_sell_price, ' .
                'round(avg(steam_price), 2) as avg_steam_price'
            );
    }

    public function scopeFilter($query, $params)
    {
        $params = $params + [
            'date_start'    => Carbon::now()->subWeek(),
            'order_by'      => 'sold',
            'order_dir'     => 'desc'
        ];

        if(isset($params['price_from']))
        {
            $query = $query->having('avg_steam_price', '>=', $params['price_from']);
        }

        if(isset($params['price_to']))
        {
            $query = $query->having('avg_steam_price', '<=', $params['price_to']);
        }

        if(isset($params['min_sold']))
        {
            $query = $query->having('sold', '>=', $params['min_sold']);
        }

        if(isset($params['max_sold']))
        {
            $query = $query->having('sold', '<=', $params['max_sold']);
        }

        return $query->apiFilter($params, [
            'search_column' => 'hash_name',
            'date_column'   => 'sold_at'
        ]);
    }

    public function scopeFilterTrend($query, $params)
    {
        $params = $params + [
            'date_start'    => Carbon::now()->subWeek(),
            'order_by'      => 'sold_at',
            'order_dir'     => 'asc'
        ];

        return $query->apiFilter($params, [
            'date_column' => 'sold_at'
        ]);
    }
}
