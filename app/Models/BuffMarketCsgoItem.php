<?php

namespace App\Models;

use App\Http\Filters\BuffMarketCsgoItemFilter;
use App\Http\Filters\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuffMarketCsgoItem extends Model implements Filterable
{
    use HasFactory, HasSerializedDate;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $primaryKey = 'hash_name';

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'hash_name',
        'volume',
        'price',
        'good_id'
    ];

    protected $casts = [
        'volume' => 'integer',
        'price' => 'float',
        'good_id' => 'integer'
    ];

    public function scopeFilter(Builder $builder, array $params): Builder
    {
        return (new BuffMarketCsgoItemFilter())->apply($builder, $params);
    }
}
