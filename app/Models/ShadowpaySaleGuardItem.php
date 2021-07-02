<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySaleGuardItem extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'hash_name',
        'shadowpay_offer_id',
        'min_price',
        'max_price'
    ];

    protected $casts = [
        'min_price'             => 'float',
        'max_price'             => 'float'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
