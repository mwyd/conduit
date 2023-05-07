<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShadowpayBotConfigFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotConfig extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    protected $hidden = [
        'user_id',
        'created_at',
    ];

    protected $fillable = [
        'user_id',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new ShadowpayBotConfigFilter())->apply($builder, $params);
    }
}
