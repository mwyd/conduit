<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShadowpayFriendFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayFriend extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    protected $hidden = [
        'user_id',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'shadowpay_user_id',
        'user_id',
    ];

    protected $casts = [
        'shadowpay_user_id' => 'integer',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new ShadowpayFriendFilter())->apply($builder, $params);
    }
}
