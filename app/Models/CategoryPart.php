<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPart extends Model
{
    protected $fillable = [
        'code',
        'name',
        'work_scope',
    ];

    protected $casts = [
        'work_scope' => 'boolean',
    ];
}
