<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySaleGuardItem extends Model
{
    use HasFactory, Filterable;

    protected $hidden = [
        'user_id'
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

    public function steamMarketCsgoItem() 
    {
        return $this->belongsTo(SteamMarketCsgoItem::class, 'hash_name');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}