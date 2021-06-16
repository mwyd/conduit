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
        'shadowpay_item_id',
        'min_price',
        'max_price'
    ];

    protected $casts = [
        'shadowpay_item_id' => 'integer',
        'min_price'         => 'float',
        'max_price'         => 'float'
    ];
}
