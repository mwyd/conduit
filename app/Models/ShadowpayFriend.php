<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayFriend extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'shadowpay_id',
        'user_id'
    ];
}
