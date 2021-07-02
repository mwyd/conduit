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
        'shadowpay_user_id',
        'user_id'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
