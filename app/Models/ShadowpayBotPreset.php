<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\ShadowpayBotPresetFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShadowpayBotPreset extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    protected $hidden = [
        'user_id',
        'created_at',
    ];

    protected $fillable = [
        'user_id',
        'preset',
    ];

    protected $casts = [
        'preset' => 'array',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new ShadowpayBotPresetFilter())->apply($builder, $params);
    }
}
