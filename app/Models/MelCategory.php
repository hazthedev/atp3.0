<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MelCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'short_id',
        'description',
        'duration_days',
        'only_one',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'only_one' => 'boolean',
    ];
}
