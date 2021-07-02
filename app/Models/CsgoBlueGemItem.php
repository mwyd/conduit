<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsgoBlueGemItem extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at'
    ];

    protected $fillable = [
        'item_type',
        'paint_seed',
        'gem_type'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
