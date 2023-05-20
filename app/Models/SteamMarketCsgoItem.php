<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\SteamMarketCsgoItemFilter;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamMarketCsgoItem extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'hash_name';

    protected $hidden = [
        'created_at',
    ];

    protected $fillable = [
        'hash_name',
        'volume',
        'price',
        'icon',
        'icon_large',
        'is_stattrak',
        'is_souvenir',
        'name',
        'name_color',
        'exterior',
        'phase',
        'collection',
        'type',
        'type_color',
    ];

    protected $casts = [
        'volume' => 'integer',
        'price' => 'float',
        'is_stattrak' => 'boolean',
        'is_souvenir' => 'boolean',
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new SteamMarketCsgoItemFilter())->apply($builder, $params);
    }
}
