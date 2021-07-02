<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamMarketCsgoItem;

class ShadowpaySoldItem extends Model
{
    use HasFactory;

    public $incrementing    = false;
    public $timestamps      = false;
    
    protected $keyType      = 'string';
    protected $primaryKey   = 'transaction_id';

    protected $fillable = [
        'transaction_id',
        'hash_name',
        'discount',
        'sell_price',
        'steam_price',
        'sold_at'
    ];

    protected $casts = [
        'discount'              => 'integer',
        'sell_price'            => 'float',
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
}
