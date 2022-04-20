<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuffMarketCsgoItem extends Model
{
    use HasFactory, HasSerializedDate, Filterable;

    public $incrementing    = false;
    
    protected $keyType      = 'string';
    protected $primaryKey   = 'hash_name';

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'hash_name',
        'volume',
        'price',
        'good_id'
    ];

    protected $casts = [
        'volume'        => 'integer',
        'price'         => 'float',
        'good_id'       => 'integer'
    ];
}
