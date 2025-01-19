<?php

namespace App\Models;

use App\Http\Filters\CsgoRarePaintSeedItemFilter;
use App\Http\Filters\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoRarePaintSeedItem extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    protected $hidden = [
        'created_at',
    ];

    protected $fillable = [
        'name',
        'paint_seed',
        'variant',
    ];

    protected $casts = [
        'paint_seed' => 'integer',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new CsgoRarePaintSeedItemFilter)->apply($builder, $params);
    }
}
