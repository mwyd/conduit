<?php

namespace App\Models;

use App\Http\Filters\Traits\Filterable;
use App\Models\Traits\HasSerializedDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoBlueGemItem extends Model
{
    use HasFactory, HasSerializedDate, Filterable;

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'item_type',
        'paint_seed',
        'gem_type'
    ];

    protected $casts = [
        'paint_seed'    => 'integer'
    ];
}