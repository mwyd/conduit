<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotPreset extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id'
    ];

    protected $fillable = [
        'user_id',
        'preset'
    ];

    protected $casts = [
        'preset' => 'array'
    ];
}
