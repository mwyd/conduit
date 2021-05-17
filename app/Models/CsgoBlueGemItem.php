<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoBlueGemItem extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'item_type',
        'paint_seed',
        'gem_type'
    ];

    protected $casts = [
        'paint_seed' => 'integer'
    ];
}
