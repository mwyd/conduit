<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayFriend extends Model
{
    use HasFactory, Filterable;

    protected $hidden = [
        'user_id',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'shadowpay_user_id',
        'user_id'
    ];

    protected $casts = [
        'shadowpay_user_id'     => 'integer'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}