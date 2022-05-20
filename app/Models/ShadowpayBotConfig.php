<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotConfig extends Model
{
    use HasFactory, HasSerializedDate, Filterable;
    
    protected $hidden = [
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'config'
    ];

    protected $casts = [
        'config' => 'array'
    ];
}
