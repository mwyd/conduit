<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpaySaleGuardItem extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id'
    ];

    protected $fillable = [
        'user_id',
        'item'
    ];

    protected $casts = [
        'item' => 'array'
    ];
}
