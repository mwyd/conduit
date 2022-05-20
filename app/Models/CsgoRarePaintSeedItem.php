<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoRarePaintSeedItem extends Model
{
    use HasFactory, HasSerializedDate, Filterable;

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'name',
        'paint_seed',
        'variant'
    ];

    protected $casts = [
        'paint_seed' => 'integer'
    ];
}
