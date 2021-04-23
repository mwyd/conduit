<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleGuardItem extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_id',
        'user_id',
        'hash_name',
        'minimum_price',
        'maximum_price'
    ];

    protected $casts = [
        'minimum_price' => 'float',
        'maximum_price' => 'float'
    ];
}
