<?php

namespace App\Models;

use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShadowpayWeeklySoldItem extends Model
{
    use HasFactory, HasSerializedDate;

    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'integer',
        'price' => 'float'
    ];

    public function scopeOld(Builder $builder): void
    {
        $builder->where('sold_at', '<', now()->modify('-7D'));
    }

    public function steamMarketCsgoItem(): BelongsTo
    {
        return $this->belongsTo(SteamMarketCsgoItem::class, 'hash_name');
    }

    public function buffMarketCsgoItem(): BelongsTo
    {
        return $this->belongsTo(BuffMarketCsgoItem::class, 'hash_name');
    }
}
