<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayFriend extends Model
{
    use HasFactory, HasSerializedDate, Filterable;

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
}