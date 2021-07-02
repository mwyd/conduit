<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamMarketCsgoItem extends Model
{
    use HasFactory;

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
        'icon'
    ];

    protected $casts = [
        'price'     => 'float'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
